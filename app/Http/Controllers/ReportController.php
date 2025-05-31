<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'last_7_days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(6));
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                          ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'last_year':
                    $query->whereYear('created_at', Carbon::now()->subYear()->year);
                    break;
                case 'current_financial_year':
                    $fyStart = Carbon::createFromDate(Carbon::now()->year, 7, 1);
                    $fyEnd = Carbon::createFromDate(Carbon::now()->year + 1, 6, 30);
                    if (Carbon::now()->month < 7) {
                        $fyStart = Carbon::createFromDate(Carbon::now()->year - 1, 7, 1);
                        $fyEnd = Carbon::createFromDate(Carbon::now()->year, 6, 30);
                    }
                    $query->whereBetween('created_at', [$fyStart, $fyEnd]);
                    break;
                case 'last_financial_year':
                    $fyStart = Carbon::createFromDate(Carbon::now()->year - 2, 7, 1);
                    $fyEnd = Carbon::createFromDate(Carbon::now()->year - 1, 6, 30);
                    if (Carbon::now()->month < 7) {
                        $fyStart = Carbon::createFromDate(Carbon::now()->year - 3, 7, 1);
                        $fyEnd = Carbon::createFromDate(Carbon::now()->year - 2, 6, 30);
                    }
                    $query->whereBetween('created_at', [$fyStart, $fyEnd]);
                    break;
            }
        }

        // Use paginate instead of get
        $orders = $query->with('items.product')->oldest()->paginate(2);

        return view('reports.index', [
            'orders' => $orders,
            'sales' => [
                'today' => $this->calculateSalesFor(Carbon::today()),
                'yesterday' => $this->calculateSalesFor(Carbon::yesterday()),
                'last_7_days' => $this->calculateSalesFrom(Carbon::today()->subDays(6)),
                'this_month' => $this->calculateSalesFrom(Carbon::now()->startOfMonth()),
                'last_month' => $this->calculateSalesFrom(Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()),
                'this_year' => $this->calculateSalesFrom(Carbon::now()->startOfYear()),
                'last_year' => $this->calculateSalesFrom(Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()),
                'current_financial_year' => $this->calculateSalesForFinancialYear(),
                'last_financial_year' => $this->calculateSalesForFinancialYear(-1),
            ],
        ]);
    }

    protected function calculateSalesFor($date)
    {
        return Order::whereDate('created_at', $date)->sum('total_amount');
    }

    protected function calculateSalesFrom($start, $end = null)
    {
        $end = $end ?? Carbon::now()->endOfDay();
        return Order::whereBetween('created_at', [$start, $end])->sum('total_amount');
    }

    protected function calculateSalesForFinancialYear($offset = 0)
    {
        $year = Carbon::now()->year + $offset;
        if (Carbon::now()->month < 7) {
            $year -= 1;
        }

        $start = Carbon::createFromDate($year, 7, 1)->startOfDay();
        $end = Carbon::createFromDate($year + 1, 6, 30)->endOfDay();

        return Order::whereBetween('created_at', [$start, $end])->sum('total_amount');
    }
}
