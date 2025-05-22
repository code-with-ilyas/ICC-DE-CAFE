<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store a newly created product
    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('message', 'Product created successfully!');
    }

    // Show the form for editing a product
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update the specified product
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
        ->route('products.index')
        ->with('success', 'Product updated successfully.');
    }

    // Delete the specified product
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
