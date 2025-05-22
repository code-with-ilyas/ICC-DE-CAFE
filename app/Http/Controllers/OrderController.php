<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Exceptions\InsufficientStockException;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    protected $stockService;
    
    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }
    
    public function index(Request $request)
    {
        $query = Order::where('printed', false);

        if ($request->has('print')) {
            $order = Order::with('items.product')->find($request->print);
            return view('orders.print', compact('order'));
        }

        $orders = $query->with('items.product')->latest()->paginate(3);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'table_number' => 'nullable|string|max:50',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,product_id',
        'items.*.quantity' => 'required|integer|min:1',
        'discount' => 'nullable|numeric|min:0',
    ]);

    try {
        return DB::transaction(function () use ($validated) {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::with('ingredients')->where('product_id', $item['product_id'])->first();

                // Check stock availability via Product method (must implement canBeMade)
                if (!$product->canBeMade($item['quantity'])) {
                    throw new InsufficientStockException("Insufficient stock for product: {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $grandTotal = $totalAmount - $discount;

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'table_number' => $validated['table_number'],
                'total_amount' => $grandTotal,
                'discount' => $discount,
                'printed' => false,
            ]);

            // Save items and reduce ingredient stock via StockService
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // Reduce stock using the service class
            app(StockService::class)->reduceStockFromOrder($order);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order created successfully.');
        });
    } catch (InsufficientStockException $e) {
        return back()->withInput()->with('error', $e->getMessage());
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'An error occurred while creating the order.');
    }
}
    
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

public function update(Request $request, Order $order)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'table_number' => 'nullable|string|max:50',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,product_id',
        'items.*.quantity' => 'required|integer|min:1',
        'discount' => 'nullable|numeric|min:0',
    ]);

    try {
        DB::transaction(function () use ($validated, $order) {
            $stockService = app(StockService::class);

            // 🔁 Step 1: Restore previous stock (reversing stock used)
            foreach ($order->items as $item) {
                $product = Product::with('ingredients')->where('product_id', $item->product_id)->first();

                foreach ($product->ingredients as $ingredient) {
                    $usedQty = $ingredient->pivot->quantity * $item->quantity;

                    // Restore ingredient stock (increase it back)
                    $ingredient->increment('stock', $usedQty);
                }
            }

            // 🔁 Step 2: Delete old items
            $order->items()->delete();

            // 🛠 Step 3: Update order data
            $totalAmount = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::with('ingredients')->where('product_id', $item['product_id'])->first();

                // Check again for updated stock
                if (!$product->canBeMade($item['quantity'])) {
                    throw new InsufficientStockException("Insufficient stock for product: {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $grandTotal = $totalAmount - $discount;

            $order->update([
                'customer_name' => $validated['customer_name'],
                'table_number' => $validated['table_number'],
                'total_amount' => $grandTotal,
                'discount' => $discount,
            ]);

            // 💾 Step 4: Recreate order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // 🔽 Step 5: Reduce stock using StockService (FIFO style)
            $stockService->reduceStockFromOrder($order);
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully.');

    } catch (InsufficientStockException $e) {
        return back()->withInput()->with('error', $e->getMessage());
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'An error occurred while updating the order.');
    }
}


    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    public function print($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        // Mark order as printed
        $order->update(['printed' => true]);
        
        return view('orders.print', compact('order'));
    }

    public function applyDiscount(Request $request, $id)
    {
        $request->validate([
            'discount' => 'required|numeric|min:0',
        ]);
    
        $order = Order::with('items')->findOrFail($id);
        $subtotal = $order->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    
        if ($request->discount > $subtotal) {
            return back()->with('error', 'Discount cannot exceed total.');
        }
    
        $order->discount = $request->discount;
        $order->total_amount = $subtotal - $request->discount;
        $order->save();
    
        return back()->with('success', 'Special discount added!');
    }
}