<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StockDashboardController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();

        // Low stock threshold
        $lowStocks = $stocks->filter(function ($s) {
            if ($s->unit === 'kg' || $s->unit === 'g') {
                return $s->quantity < 1000; // less than 1kg
            } elseif ($s->unit === 'liter' || $s->unit === 'ml') {
                return $s->quantity < 1000; // less than 1 liter
            } elseif ($s->unit === 'pcs') {
                return $s->quantity < 10;   // less than 10 pieces
            }
            return false;
        });

        // Last 30 days usage
        $from = Carbon::now()->subDays(30);
        $usageData = StockLog::with('stock')
            ->where('type', 'deducted')
            ->where('created_at', '>=', $from)
            ->selectRaw('stock_id, SUM(quantity) as used')
            ->groupBy('stock_id')
            ->get();

        // Top 5 used ingredients
        $topUsed = $usageData->sortByDesc('used')->take(5);

        // Total stock value
        $totalValue = $stocks->sum(function($s) {
            $isLargeUnit = ($s->unit === 'kg' || $s->unit === 'liter');
            return $s->price * ($isLargeUnit ? $s->quantity / 1000 : $s->quantity);
        });

        return view('dashboard.stocks', compact('stocks', 'lowStocks', 'usageData', 'topUsed', 'totalValue'));
    }
}
