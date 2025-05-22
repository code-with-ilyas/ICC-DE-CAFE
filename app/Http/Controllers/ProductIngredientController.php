<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use Illuminate\Http\Request;

class ProductIngredientController extends Controller
{
    // Display all ingredients for a specific product
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $productIngredients = ProductIngredient::with('ingredient')
                                ->where('product_id', $productId)
                                ->get();

        return view('product.ingredients.index', compact('product', 'productIngredients'));
    }

    // Show form to add a new ingredient to a product
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        $ingredients = Ingredient::all();

        return view('product.ingredients.create', compact('product', 'ingredients'));
    }

    // Store a new product ingredient
    public function store(Request $request, $productId)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $product = Product::findOrFail($productId);

        // Prevent duplicate ingredient entries for same product
        $exists = ProductIngredient::where('product_id', $productId)
            ->where('ingredient_id', $request->ingredient_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This ingredient is already assigned to the product.');
        }

        ProductIngredient::create([
            'product_id' => $productId,
            'ingredient_id' => $request->ingredient_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('products.ingredients.index', $productId)->with('success', 'Ingredient added to product successfully.');
    }

    // Show form to edit an existing product ingredient
    public function edit($productId, $id)
    {
        $product = Product::findOrFail($productId);
        $productIngredient = ProductIngredient::findOrFail($id);
        $ingredients = Ingredient::all();

        return view('product.ingredients.edit', compact('product', 'productIngredient', 'ingredients'));
    }

    // Update an existing product ingredient
    public function update(Request $request, $productId, $id)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $productIngredient = ProductIngredient::findOrFail($id);
        $productIngredient->update([
            'ingredient_id' => $request->ingredient_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('products.ingredients.index', $productId)->with('success', 'Ingredient updated successfully.');
    }

    // Delete a product ingredient
    public function destroy($productId, $id)
    {
        $productIngredient = ProductIngredient::findOrFail($id);
        $productIngredient->delete();

        return redirect()->route('products.ingredients.index', $productId)->with('success', 'Ingredient removed from product.');
    }
}
