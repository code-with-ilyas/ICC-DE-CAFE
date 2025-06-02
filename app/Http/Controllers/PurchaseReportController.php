<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseStock;
use Carbon\Carbon;

class PurchaseReportController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseStock::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Paginate results
        $purchaseStocks = $query->latest()->paginate(50);

        // Dynamically calculate total purchase value from quantity * unit_price
        $calculateTotal = fn($stocks) => $stocks->sum(function ($stock) {
            return $stock->quantity * $stock->unit_price;
        });

        $now = Carbon::now();
        $startFinancialYear = Carbon::create($now->month >= 7 ? $now->year : $now->year - 1, 7, 1);
        $lastFinancialYearStart = $startFinancialYear->copy()->subYear();
        $lastFinancialYearEnd = $startFinancialYear->copy()->subDay();

        $sales = [
            'today' => $calculateTotal(PurchaseStock::whereDate('created_at', $now)->get()),
            'yesterday' => $calculateTotal(PurchaseStock::whereDate('created_at', $now->copy()->subDay())->get()),
            'last_7_days' => $calculateTotal(PurchaseStock::whereBetween('created_at', [$now->copy()->subDays(6), $now])->get()),
            'this_month' => $calculateTotal(PurchaseStock::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->get()),
            'last_month' => $calculateTotal(PurchaseStock::whereMonth('created_at', $now->copy()->subMonth()->month)->whereYear('created_at', $now->copy()->subMonth()->year)->get()),
            'this_year' => $calculateTotal(PurchaseStock::whereYear('created_at', $now->year)->get()),
            'last_year' => $calculateTotal(PurchaseStock::whereYear('created_at', $now->copy()->subYear()->year)->get()),
            'current_financial_year' => $calculateTotal(PurchaseStock::whereBetween('created_at', [$startFinancialYear, $now])->get()),
            'last_financial_year' => $calculateTotal(PurchaseStock::whereBetween('created_at', [$lastFinancialYearStart, $lastFinancialYearEnd])->get()),
        ];

        return view('purchase_reports.index', compact('purchaseStocks', 'sales'));
    }
}
