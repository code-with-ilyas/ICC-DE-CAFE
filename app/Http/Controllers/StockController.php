<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::latest()->paginate(20);
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    /**
     * STORE STOCK (convert to base unit)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|in:kg,liter,pcs',
            'price' => 'nullable|numeric|min:0',
        ]);

        $quantity = $this->toBaseUnit($request->quantity, $request->unit);

        Stock::create([
            'name' => $request->name,
            'quantity' => $quantity, // ✅ base unit only
            'unit' => $request->unit,
            'price' => $request->price,
        ]);

        return redirect()->route('stocks.index')
            ->with('success', 'Stock added successfully');
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    /**
     * UPDATE STOCK (convert to base unit AGAIN)
     */
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|in:kg,liter,pcs',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $quantity = $this->toBaseUnit($request->quantity, $request->unit);

        $stock->update([
            'name' => $request->name,
            'quantity' => $quantity, // ✅ base unit
            'unit' => $request->unit,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('stocks.index')
            ->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stocks.index')
            ->with('success', 'Stock deleted successfully.');
    }

    /**
     * 🔑 Helper: convert input to base unit
     */
    private function toBaseUnit(float $qty, string $unit): float
    {
        return match ($unit) {
            'kg', 'liter' => $qty * 1000, // kg → g, liter → ml
            default => $qty,              // pcs
        };
    }
}
