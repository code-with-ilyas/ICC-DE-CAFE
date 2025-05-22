<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of all stock movements.
     */
    public function index(Request $request)
    {
        $query = StockMovement::with(['ingredient', 'purchaseStock', 'order']);
        
        // Filter by ingredient if provided
        if ($request->has('ingredient_id') && $request->ingredient_id) {
            $query->where('ingredient_id', $request->ingredient_id);
        }
        
        // Filter by type if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        // Filter by date range if provided
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        $stockMovements = $query->latest()->paginate(20);
        $ingredients = Ingredient::all();
        
        return view('stock_movements.index', compact('stockMovements', 'ingredients'));
    }

    /**
     * Show movements for a specific ingredient.
     */
    public function ingredientMovements(Ingredient $ingredient)
    {
        $stockMovements = StockMovement::where('ingredient_id', $ingredient->id)
            ->with(['purchaseStock', 'order'])
            ->latest()
            ->paginate(20);
            
        return view('stock_movements.ingredient', compact('ingredient', 'stockMovements'));
    }
}