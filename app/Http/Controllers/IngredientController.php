<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        Ingredient::create($validated);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient created successfully.');
    }

    public function show(Ingredient $ingredient)
    {
        return view('ingredients.show', compact('ingredient'));
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $ingredient->update($validated);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient deleted successfully.');
    }
    
    public function stock()
    {
        $ingredients = Ingredient::with('purchaseStocks')->get();
        
        // Calculate current stock for each ingredient
        $ingredients->each(function ($ingredient) {
            $ingredient->current_stock = $ingredient->getCurrentStock();
        });
        
        return view('ingredients.stock', compact('ingredients'));
    }
}