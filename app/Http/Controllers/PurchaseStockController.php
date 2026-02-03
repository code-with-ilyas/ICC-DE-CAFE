<?php

namespace App\Http\Controllers;

use App\Models\PurchaseStock;
use Illuminate\Http\Request;

class PurchaseStockController extends Controller
{
    public function index()
    {
        $purchaseStocks = PurchaseStock::orderBy('date', 'desc')->paginate(100);
        return view('purchase_stocks.index', compact('purchaseStocks'));
    }

    public function create()
    {
        return view('purchase_stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name'    => 'required|string|max:255',
            'supplier_number'  => 'nullable|string|max:255',
            'date'             => 'required|date',
            'product_name.*'   => 'required|string|max:255',
            'quantity.*'       => 'required|string|max:255',
            'unit_price.*'     => 'required|numeric|min:0',
        ]);

        foreach ($request->product_name as $index => $productName) {
            $unitPrice = $request->unit_price[$index];
            $quantity  = $request->quantity[$index];

            $quantityValue = floatval(preg_replace('/[^0-9.]/', '', $quantity)); // Extract numeric value from quantity
            $totalPrice = $unitPrice * $quantityValue;

            PurchaseStock::create([
                'supplier_name'   => $request->supplier_name,
                'supplier_number' => $request->supplier_number,
                'date'            => $request->date,
                'product_name'    => $productName,
                'quantity'        => $quantity,
                'unit_price'      => $unitPrice,
                'total_price'     => $totalPrice,
            ]);
        }

        return redirect()->route('purchase_stocks.index')->with('success', 'Purchase stock added successfully.');
    }

    public function show(PurchaseStock $purchaseStock)
    {
        return view('purchase_stocks.show', compact('purchaseStock'));
    }

    public function edit(PurchaseStock $purchaseStock)
    {
        return view('purchase_stocks.edit', compact('purchaseStock'));
    }

    public function update(Request $request, PurchaseStock $purchaseStock)
    {
        $request->validate([
            'supplier_name'    => 'required|string|max:255',
            'supplier_number'  => 'nullable|string|max:255',
            'date'             => 'required|date',
            'product_name'     => 'required|string|max:255',
            'quantity'         => 'required|string|max:255',
            'unit_price'       => 'required|numeric|min:0',
        ]);

        $unitPrice = $request->unit_price;
        $quantityValue = floatval(preg_replace('/[^0-9.]/', '', $request->quantity));
        $totalPrice = $unitPrice * $quantityValue;

        $purchaseStock->update([
            'supplier_name'   => $request->supplier_name,
            'supplier_number' => $request->supplier_number,
            'date'            => $request->date,
            'product_name'    => $request->product_name,
            'quantity'        => $request->quantity,
            'unit_price'      => $unitPrice,
            'total_price'     => $totalPrice,
        ]);

        return redirect()->route('purchase_stocks.index')->with('success', 'Purchase stock updated successfully.');
    }

    public function destroy(PurchaseStock $purchaseStock)
    {
        $purchaseStock->delete();
        return redirect()->route('purchase_stocks.index')->with('success', 'Purchase stock deleted successfully.');
    }
}
