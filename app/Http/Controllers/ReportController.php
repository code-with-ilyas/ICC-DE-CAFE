<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PurchaseStock;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        $startDate = null;
        $endDate = null;

        // Date range filter
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Predefined filters like today, last month, etc.
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

        $orders = $query->with('items.product')->oldest()->paginate(120);

        // Sum total_amount for filtered orders
        $totalSalesOverall = (clone $query)->sum('total_amount');

        // Subtract purchases (using total_price) + expenses
        $purchaseTotal = PurchaseStock::when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]); // use purchase date
        })->sum('total_price');

        $expenseTotal = Expense::when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })->sum('amount');

        $netTotal = $totalSalesOverall - ($purchaseTotal + $expenseTotal);

        // Items Sold Summary (for filter range)
        $itemsSoldSummary = OrderItem::with('product')
            ->whereHas('order', function ($orderQuery) use ($request) {
                if ($request->filled(['start_date', 'end_date'])) {
                    $orderQuery->whereBetween('created_at', [
                        Carbon::parse($request->start_date)->startOfDay(),
                        Carbon::parse($request->end_date)->endOfDay()
                    ]);
                } elseif ($request->filled('filter')) {
                    switch ($request->filter) {
                        case 'today':
                            $orderQuery->whereDate('created_at', Carbon::today());
                            break;
                        case 'yesterday':
                            $orderQuery->whereDate('created_at', Carbon::yesterday());
                            break;
                        case 'last_7_days':
                            $orderQuery->where('created_at', '>=', Carbon::now()->subDays(6));
                            break;
                        case 'this_month':
                            $orderQuery->whereMonth('created_at', Carbon::now()->month)
                                       ->whereYear('created_at', Carbon::now()->year);
                            break;
                        case 'last_month':
                            $orderQuery->whereMonth('created_at', Carbon::now()->subMonth()->month)
                                       ->whereYear('created_at', Carbon::now()->subMonth()->year);
                            break;
                        case 'this_year':
                            $orderQuery->whereYear('created_at', Carbon::now()->year);
                            break;
                        case 'last_year':
                            $orderQuery->whereYear('created_at', Carbon::now()->subYear()->year);
                            break;
                        case 'current_financial_year':
                            $fyStart = Carbon::createFromDate(Carbon::now()->year, 7, 1);
                            $fyEnd = Carbon::createFromDate(Carbon::now()->year + 1, 6, 30);
                            if (Carbon::now()->month < 7) {
                                $fyStart = Carbon::createFromDate(Carbon::now()->year - 1, 7, 1);
                                $fyEnd = Carbon::createFromDate(Carbon::now()->year, 6, 30);
                            }
                            $orderQuery->whereBetween('created_at', [$fyStart, $fyEnd]);
                            break;
                        case 'last_financial_year':
                            $fyStart = Carbon::createFromDate(Carbon::now()->year - 2, 7, 1);
                            $fyEnd = Carbon::createFromDate(Carbon::now()->year - 1, 6, 30);
                            if (Carbon::now()->month < 7) {
                                $fyStart = Carbon::createFromDate(Carbon::now()->year - 3, 7, 1);
                                $fyEnd = Carbon::createFromDate(Carbon::now()->year - 2, 6, 30);
                            }
                            $orderQuery->whereBetween('created_at', [$fyStart, $fyEnd]);
                            break;
                    }
                } else {
                    $orderQuery->whereDate('created_at', Carbon::today());
                }
            })
            ->get()
            ->groupBy('product.name')
            ->map(fn($items) => $items->sum('quantity'));

        // --- New: Product Sales ---
        $todayProductSales = OrderItem::with('product')
            ->whereHas('order', function ($q) {
                $q->whereDate('created_at', Carbon::today());
            })
            ->select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->get();

        $overallProductSales = OrderItem::with('product')
            ->select('product_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->get();

        // --- New: Category Sales ---
        $todayCategorySales = OrderItem::with('product.category')
            ->whereHas('order', function ($q) {
                $q->whereDate('created_at', Carbon::today());
            })
            ->get()
            ->groupBy('product.category.name')
            ->map(fn($items) => $items->sum('quantity'));

        $overallCategorySales = OrderItem::with('product.category')
            ->get()
            ->groupBy('product.category.name')
            ->map(fn($items) => $items->sum('quantity'));

        return view('reports.index', [
            'orders' => $orders,
            'sales' => [
                'today' => $this->calculateSalesFor(Carbon::today()),
                'yesterday' => $this->calculateSalesFor(Carbon::yesterday()),
                'last_7_days' => $this->calculateSalesFrom(Carbon::today()->subDays(6)),
                'this_month' => $this->calculateSalesFrom(Carbon::now()->startOfMonth()),
                'last_month' => $this->calculateSalesFrom(
                    Carbon::now()->subMonth()->startOfMonth(),
                    Carbon::now()->subMonth()->endOfMonth()
                ),
                'this_year' => $this->calculateSalesFrom(Carbon::now()->startOfYear()),
                'last_year' => $this->calculateSalesFrom(
                    Carbon::now()->subYear()->startOfYear(),
                    Carbon::now()->subYear()->endOfYear()
                ),
                'current_financial_year' => $this->calculateSalesForFinancialYear(),
                'last_financial_year' => $this->calculateSalesForFinancialYear(-1),
            ],
            'totalSalesOverall' => $totalSalesOverall,
            'purchaseTotal' => $purchaseTotal,
            'expenseTotal' => $expenseTotal,
            'netTotal' => $netTotal,
            'itemsSoldSummary' => $itemsSoldSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            // New data
            'todayProductSales' => $todayProductSales,
            'overallProductSales' => $overallProductSales,
            'todayCategorySales' => $todayCategorySales,
            'overallCategorySales' => $overallCategorySales,
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


public function salesSummary(Request $request)
    {
        // ======================
        // DATE LOGIC (CORE)
        // ======================
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $year  = $request->year;
        $month = $request->month;

        $startDate = null;
        $endDate   = null;

        if ($year && $month) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate   = Carbon::create($year, $month, 1)->endOfMonth();
        } elseif ($year) {
            $startDate = Carbon::create($year, 1, 1)->startOfYear();
            $endDate   = Carbon::create($year, 12, 31)->endOfYear();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate   = Carbon::now()->endOfMonth();
        }

        // ======================
        // PRODUCT SALES
        // ======================
        $overallProductSales = OrderItem::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->with('product')
            ->get();

        $todayProductSales = OrderItem::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->whereDate('created_at', $today)
            ->groupBy('product_id')
            ->get();

        $yesterdayProductSales = OrderItem::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->whereDate('created_at', $yesterday)
            ->groupBy('product_id')
            ->get();

        $monthlyProductSales = OrderItem::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_id')
            ->get();

        // ======================
        // CATEGORY SALES
        // ======================
        $overallCategorySales = OrderItem::with('product.category')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn ($i) => $i->product->category->name ?? 'Uncategorized')
            ->map(fn ($g) => $g->sum('quantity'));

        $todayCategorySales = OrderItem::with('product.category')
            ->whereDate('created_at', $today)
            ->get()
            ->groupBy(fn ($i) => $i->product->category->name ?? 'Uncategorized')
            ->map(fn ($g) => $g->sum('quantity'));

        $yesterdayCategorySales = OrderItem::with('product.category')
            ->whereDate('created_at', $yesterday)
            ->get()
            ->groupBy(fn ($i) => $i->product->category->name ?? 'Uncategorized')
            ->map(fn ($g) => $g->sum('quantity'));

        $monthlyCategorySales = OrderItem::with('product.category')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(fn ($i) => $i->product->category->name ?? 'Uncategorized')
            ->map(fn ($g) => $g->sum('quantity'));

        return view('reports.sales_summary', compact(
            'overallProductSales',
            'todayProductSales',
            'yesterdayProductSales',
            'monthlyProductSales',
            'overallCategorySales',
            'todayCategorySales',
            'yesterdayCategorySales',
            'monthlyCategorySales',
            'year',
            'month'
        ));
    }
}
