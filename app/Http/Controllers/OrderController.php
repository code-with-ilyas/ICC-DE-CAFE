<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->toDateString();
<<<<<<< Updated upstream

        $query = Order::whereDate('created_at', $today)
            ->where('printed', false);

        if ($request->has('print')) {
            $order = Order::with('items.product')->find($request->print);
            return view('orders.print', compact('order'));
        }

        $orders = $query->with('items.product')->latest()->paginate(50);
        return view('orders.index', compact('orders'));
=======

        $query = Order::whereDate('created_at', $today)
            ->where('printed', false);

        if ($request->has('print')) {
            $order = Order::with('items.product')->find($request->print);
            return view('orders.print', compact('order'));
        }

        $orders = $query->with('items.product')->latest()->paginate(50);

        return view('orders.index', compact('orders'));
    }

    public function print($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if (!$order->printed) {
            $order->printed = true;
            $order->save();
        }

        return view('orders.print', compact('order'));
>>>>>>> Stashed changes
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.product_name' => 'required|string',
            'discount' => 'nullable|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
<<<<<<< Updated upstream

            $total = 0;

            foreach ($validated['items'] as &$item) {
                $product = Product::findOrFail($item['product_id']);
                $item['size'] = $this->detectSizeFromName($item['product_name']);
                $item['price'] = $product->price;
                $item['subtotal'] = $product->price * $item['quantity'];
                $total += $item['subtotal'];
            }

=======
            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;
            }

            $discount = $validated['discount'] ?? 0;
            $grandTotal = $totalAmount - $discount;

>>>>>>> Stashed changes
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'table_number'  => $validated['table_number'],
                'discount'      => $validated['discount'] ?? 0,
                'total_amount'  => $total - ($validated['discount'] ?? 0),
                'printed'       => false,
            ]);

            foreach ($validated['items'] as $item) {

                $orderItem = $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $item['subtotal'],
                ]);

                /**
                 * ✅ STOCK DEDUCTION
                 * ProductStock.quantity = BASE UNIT (g/ml/pcs)
                 * Stock.quantity        = BASE UNIT
                 */
                foreach ($orderItem->product->productStocks as $ps) {
                    if (!$ps->stock) continue;

                    $deductBase = $ps->quantity * $item['quantity'];
                    $ps->stock->deduct($deductBase, 'g'); // ✅ FIX
                }
            }

<<<<<<< Updated upstream
            return redirect()->route('orders.index')
                ->with('success', 'Order created successfully');
        });
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'discount' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $order) {

            /** 🔁 RESTORE OLD STOCK */
            foreach ($order->items as $oldItem) {
                foreach ($oldItem->product->productStocks as $ps) {
                    if (!$ps->stock) continue;

                    $restoreBase = $ps->quantity * $oldItem->quantity;
                    $ps->stock->add($restoreBase, 'g'); // ✅ FIX
                }
            }

            $order->items()->delete();

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $orderItem = $order->items()->create([
                    'product_id' => $product->product_id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                    'subtotal'   => $subtotal,
                ]);

                /** 🔻 DEDUCT NEW STOCK */
                foreach ($product->productStocks as $ps) {
                    if (!$ps->stock) continue;

                    $deductBase = $ps->quantity * $item['quantity'];
                    $ps->stock->deduct($deductBase, 'g'); // ✅ FIX
                }
            }

            $discount = $validated['discount'] ?? 0;
            $order->update([
                'customer_name' => $validated['customer_name'],
                'table_number'  => $validated['table_number'],
                'total_amount'  => $total - $discount,
                'discount'      => $discount,
            ]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }
=======
            return redirect()->route('orders.index', $order)
                ->with('success', 'Order created successfully.');
        });
    }
>>>>>>> Stashed changes

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

<<<<<<< Updated upstream
=======
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
            // Clear previous items
            $order->items()->delete();

            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $order->items()->create([
                    'product_id' => $product->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            $discount = $validated['discount'] ?? $order->discount ?? 0;
            $grandTotal = $totalAmount - $discount;

            $order->update([
                'customer_name' => $validated['customer_name'],
                'table_number' => $validated['table_number'],
                'total_amount' => $grandTotal,
                'discount' => $discount,
            ]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

>>>>>>> Stashed changes
    public function destroy(Order $order)
{
    /** 🔁 RESTORE STOCK BEFORE DELETE */
    foreach ($order->items as $item) {
        foreach ($item->product->productStocks as $ps) {
            if (!$ps->stock) continue;

            $restoreBase = $ps->quantity * $item->quantity;
            $ps->stock->add($restoreBase, 'g'); // ✅ FIX
        }
    }

<<<<<<< Updated upstream
    $order->items()->delete();
    $order->delete();

    return redirect()->route('orders.index')
        ->with('success', 'Order deleted successfully.');
}


=======
>>>>>>> Stashed changes
    public function applyDiscount(Request $request, $id)
    {
        $request->validate([
            'discount' => 'required|numeric|min:0',
        ]);

        $order = Order::with('items')->findOrFail($id);
        $subtotal = $order->items->sum(fn($i) => $i->quantity * $i->price);

        if ($request->discount > $subtotal) {
            return back()->with('error', 'Discount cannot exceed total.');
        }

        $order->update([
            'discount' => $request->discount,
            'total_amount' => $subtotal - $request->discount,
        ]);

        return back()->with('success', 'Special discount added!');
    }

    public function kitchenPrint(Order $order)
    {
<<<<<<< Updated upstream
        $order->load('items.product');
        return view('orders.kitchen_print', compact('order'));
    }

    private function detectSizeFromName(string $name): ?string
    {
        $name = strtolower($name);

        if (str_contains($name, 'small')) return 'small';
        if (str_contains($name, 'medium')) return 'medium';
        if (str_contains($name, 'large')) return 'large';

        return null;
    }

    public function print($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        if (!$order->printed) {
            $order->printed = true;
            $order->save();
        }
        return view('orders.print', compact('order'));
    }
=======
        $order->load('orderItems.product');
        return view('orders.kitchen_print', compact('order'));
    }
>>>>>>> Stashed changes
}
