<?php

namespace App\Http\Controllers;

use App\Models\PurchaseStock;
use App\Models\Ingredient;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseStockController extends Controller
{
    public function index()
    {
        $purchaseStocks = PurchaseStock::with('ingredient')->latest()->get();
        return view('purchase_stocks.index', compact('purchaseStocks'));
    }

    public function create()
    {
        $ingredients = Ingredient::all();
        return view('purchase_stocks.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0.01',
            'cost_price' => 'required|numeric|min:0.01',
            'purchase_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:purchase_date',
            'supplier' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
        ]);

        // Set remaining quantity to the initial quantity
        $validated['remaining_quantity'] = $validated['quantity'];
        
        DB::transaction(function () use ($validated) {
            // Create purchase stock
            $purchaseStock = PurchaseStock::create($validated);
            
            // Create stock movement
            StockMovement::create([
                'ingredient_id' => $validated['ingredient_id'],
                'purchase_stock_id' => $purchaseStock->id,
                'type' => 'purchase',
                'quantity' => $validated['quantity'],
                'remaining_balance' => $validated['quantity'],
                'notes' => 'Initial purchase'
            ]);
        });

        return redirect()->route('purchase-stocks.index')
            ->with('success', 'Purchase stock recorded successfully.');
    }

    public function show(PurchaseStock $purchaseStock)
    {
        return view('purchase_stocks.show', compact('purchaseStock'));
    }

    public function edit(PurchaseStock $purchaseStock)
    {
        $ingredients = Ingredient::all();
        return view('purchase_stocks.edit', compact('purchaseStock', 'ingredients'));
    }

    public function update(Request $request, PurchaseStock $purchaseStock)
    {
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0.01',
            'cost_price' => 'required|numeric|min:0.01',
            'purchase_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:purchase_date',
            'supplier' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
        ]);

        // Handle remaining quantity
        $oldQuantity = $purchaseStock->quantity;
        $newQuantity = $validated['quantity'];
        
        // Adjust remaining quantity proportionally
        if ($oldQuantity != 0) {
            $ratio = $newQuantity / $oldQuantity;
            $validated['remaining_quantity'] = $purchaseStock->remaining_quantity * $ratio;
        } else {
            $validated['remaining_quantity'] = $newQuantity;
        }
        
        DB::transaction(function () use ($purchaseStock, $validated, $oldQuantity, $newQuantity) {
            $purchaseStock->update($validated);
            
            // Create adjustment stock movement
            if ($oldQuantity != $newQuantity) {
                StockMovement::create([
                    'ingredient_id' => $validated['ingredient_id'],
                    'purchase_stock_id' => $purchaseStock->id,
                    'type' => 'adjustment',
                    'quantity' => $newQuantity - $oldQuantity, // Positive for increase, negative for decrease
                    'remaining_balance' => $validated['remaining_quantity'],
                    'notes' => 'Quantity adjustment'
                ]);
            }
        });

        return redirect()->route('purchase-stocks.index')
            ->with('success', 'Purchase stock updated successfully.');
    }

    public function destroy(PurchaseStock $purchaseStock)
    {
        if ($purchaseStock->remaining_quantity < $purchaseStock->quantity) {
            return redirect()->route('purchase-stocks.index')
                ->with('error', 'Cannot delete purchase stock that has been used.');
        }
        
        $purchaseStock->delete();

        return redirect()->route('purchase-stocks.index')
            ->with('success', 'Purchase stock deleted successfully.');
    }
}