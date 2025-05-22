<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\PurchaseStock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\InsufficientStockException;

class StockService
{
    /**
     * Reduce stock levels based on order
     */
    public function reduceStockFromOrder(Order $order)
    {
        return DB::transaction(function () use ($order) {
            foreach ($order->orderItems as $orderItem) {
                $product = Product::findOrFail($orderItem->product_id);
                
                // Check if can be made with current stock
                if (!$product->canBeMade($orderItem->quantity)) {
                    throw new InsufficientStockException("Insufficient stock for product: {$product->name}");
                }
                
                $this->reduceStockForProduct($product, $orderItem->quantity, $order->id);
            }
            return true;
        });
    }
    
    /**
     * Reduce stock for a single product
     */
    protected function reduceStockForProduct(Product $product, $quantity, $orderId)
    {
        // Get all ingredients needed for this product
        foreach ($product->ingredients as $ingredient) {
            $requiredAmount = $ingredient->pivot->quantity * $quantity;
            
            $this->reduceIngredientStock($ingredient->id, $requiredAmount, $orderId);
        }
    }
    
    /**
     * Reduce stock for a single ingredient
     */
    protected function reduceIngredientStock($ingredientId, $requiredAmount, $orderId)
    {
        // Get available stocks ordered by expiry date (FIFO)
        $purchaseStocks = PurchaseStock::where('ingredient_id', $ingredientId)
            ->where('remaining_quantity', '>', 0)
            ->orderBy('expiry_date') // FIFO by expiry
            ->get();
            
        $remainingToReduce = $requiredAmount;
        
        foreach ($purchaseStocks as $stock) {
            if ($remainingToReduce <= 0) {
                break;
            }
            
            $amountToReduce = min($remainingToReduce, $stock->remaining_quantity);
            $remainingToReduce -= $amountToReduce;
            
            // Update purchase stock
            $stock->remaining_quantity -= $amountToReduce;
            $stock->save();
            
            // Record stock movement
            StockMovement::create([
                'ingredient_id' => $ingredientId,
                'purchase_stock_id' => $stock->id,
                'order_id' => $orderId,
                'type' => 'order',
                'quantity' => -$amountToReduce, // Negative for reduction
                'remaining_balance' => $stock->remaining_quantity,
                'notes' => "Used for order #{$orderId}"
            ]);
        }
        
        // If we couldn't satisfy the request (should not happen due to canBeMade check)
        if ($remainingToReduce > 0) {
            throw new Exception("Stock reduction failed: Not enough stock for ingredient #{$ingredientId}");
        }
    }

    /**
     * Return total available stock for an ingredient
     */
    public function getAvailableStock($ingredientId)
    {
        return PurchaseStock::where('ingredient_id', $ingredientId)
            ->sum('remaining_quantity');
    }
}