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

        $orders = $query->with('items.product')->latest()->get();

        return view('reports.index', [
            'orders' => $orders,
            'sales' => [
                'today' => $this->calculateSalesFor(Carbon::today()),
                'yesterday' => $this->calculateSalesFor(Carbon::yesterday()),
                'last_7_days' => $this->calculateSalesFrom(Carbon::today()->subDays(6)),
                'this_month' => $this->calculateSalesFrom(Carbon::now()->startOfMonth()),
            ],
        ]);
    }

    protected function calculateSalesFor($day)
    {
        return Order::whereDate('created_at', $day)->sum('total_amount');
    }

    protected function calculateSalesFrom($from)
    {
        return Order::where('created_at', '>=', $from)->sum('total_amount');
    }
}
