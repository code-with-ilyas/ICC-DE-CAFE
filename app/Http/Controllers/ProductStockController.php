<?php

namespace App\Http\Controllers;

use App\Models\ProductStock;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    public function index()
    {
        $productStocks = ProductStock::with('product', 'stock')->latest()->paginate(20);
        return view('product_stock.index', compact('productStocks'));
    }

    public function create()
    {
        $products = Product::all();
        $stocks = Stock::all();
        return view('product_stock.create', compact('products', 'stocks'));
    }

  public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,product_id',
        'stock_id'   => 'required|exists:stocks,id',
        'quantity'   => 'required|numeric|min:0',
    ]);

    // ✅ ONLY save recipe
    ProductStock::create($request->all());

    return redirect()->route('product-stock.index')
        ->with('success', 'Ingredient added to product recipe successfully!');
}


    public function edit(ProductStock $productStock)
    {
        $products = Product::all();
        $stocks = Stock::all();
        return view('product_stock.edit', compact('productStock', 'products', 'stocks'));
    }

   public function update(Request $request, ProductStock $productStock)
{
    $request->validate([
        'product_id' => 'required|exists:products,product_id',
        'stock_id'   => 'required|exists:stocks,id',
        'quantity'   => 'required|numeric|min:0',
    ]);

    $productStock->update($request->all());

    return redirect()->route('product-stock.index')
        ->with('success', 'Product ingredient updated!');
}


   public function destroy(ProductStock $productStock)
{
    $productStock->delete();

    return back()->with('success', 'Ingredient removed from recipe!');
}

}
