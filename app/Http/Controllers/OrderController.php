<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   // Updated index method
public function index(Request $request)
{
    $printedOrders = session()->get('printed_orders', []);
    
    $query = Order::whereNotIn('id', $printedOrders);

    if ($request->has('print')) {
        $order = Order::with('items.product')->find($request->print);
        return view('orders.print', compact('order'));
    }

    $orders = $query->with('items.product')->latest()->paginate(50);

    return view('orders.index', compact('orders'));
}

// Updated print method
public function print($id)
{
    $order = Order::with('items.product')->findOrFail($id);
    
    // Add order ID to session array of printed orders
    $printedOrders = session()->get('printed_orders', []);
    if (!in_array($id, $printedOrders)) {
        $printedOrders[] = $id;
        session()->put('printed_orders', $printedOrders);
    }
    
    return view('orders.print', compact('order'));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
        ]);
    
        return DB::transaction(function () use ($validated) {
            $totalAmount = 0;
    
            // Calculate total amount
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;
            }
    
            $discount = $validated['discount'] ?? 0;
            $grandTotal = $totalAmount - $discount;
    
            // Create order
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'table_number' => $validated['table_number'],
                'total_amount' => $grandTotal,
                'discount' => $discount,
                'printed' => false,
            ]);
    
            // Create order items
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $order->items()->create([
                    'product_id' => $product->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);
            }
    
            return redirect()->route('orders.index', $order)
                ->with('success', 'Order created successfully.');
        });
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
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,product_id',
        'items.*.quantity' => 'required|integer|min:1',
        'discount' => 'nullable|numeric|min:0',
    ]);

    DB::transaction(function () use ($validated, $order) {
        // Delete existing order items
        $order->items()->delete();

        $totalAmount = 0;

        // Calculate total amount for new items
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;
        }

        $discount = $validated['discount'] ?? 0;
        $grandTotal = $totalAmount - $discount;

        // Update the order
        $order->update([
            'customer_name' => $validated['customer_name'],
            'table_number' => $validated['table_number'],
            'total_amount' => $grandTotal,
            'discount' => $discount,
        ]);

        // Create new order items
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $order->items()->create([
                'product_id' => $product->product_id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);
        }
    });

    return redirect()->route('orders.index', $order)
        ->with('success', 'Order updated successfully.');
}


    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
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

public function kitchenPrint(Order $order)
{
    // Eager load orderItems and related products to avoid N+1 queries
    $order->load('orderItems.product');

    // Pass $order to the view
    return view('orders.kitchen_print', compact('order'));
}


}
