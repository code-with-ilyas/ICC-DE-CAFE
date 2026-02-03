<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class IngredientcalculationController extends Controller
{
    public function index(Request $request)
    {
        [$ingredients, $monthlySummary] = $this->calculateIngredients($request);
        return view('ingredients.index', compact('ingredients', 'monthlySummary'));
    }

    public function downloadPdf(Request $request)
    {
        [$ingredients, $monthlySummary] = $this->calculateIngredients($request);

        $year = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->year
            : now()->year;

        $pdf = Pdf::loadView(
            'ingredients.pdf',
            compact('ingredients', 'monthlySummary', 'year')
        );

        return $pdf->download("ingredients_report_$year.pdf");
    }

    private function calculateIngredients(Request $request): array
    {
        $query = Order::with('items.product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->get();

        // RULES (grams)
        $rules = [
            'cheese'  => ['small' => 10, 'medium' => 20, 'large' => 30],
            'chicken' => ['small' => 40, 'medium' => 60, 'large' => 80],
            'fries'   => ['plate' => 50, 'with_burger' => 20],
        ];

        $ingredients = [];
        $monthlySummary = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlySummary[$m] = [
                'cheese' => ['small' => 0, 'medium' => 0, 'large' => 0, 'total' => 0],
                'chicken'=> ['small' => 0, 'medium' => 0, 'large' => 0, 'total' => 0],
                'fries'  => ['plate' => 0, 'with_burger' => 0, 'total' => 0],
            ];
        }

        foreach ($orders as $order) {
            $month = $order->created_at->month;

            foreach ($order->items as $item) {
                $name = strtolower($item->product->name);

                // 🍕 Pizza → Cheese + Chicken
                if (str_contains($name, 'pizza')) {
                    $size = $this->detectSize($name);

                    // Cheese
                    $cheeseAmount = $rules['cheese'][$size] * $item->quantity;
                    $this->addIngredient($ingredients, 'cheese', $size, $cheeseAmount);
                    $this->addIngredient($monthlySummary[$month], 'cheese', $size, $cheeseAmount);

                    // Chicken
                    $chickenAmount = $rules['chicken'][$size] * $item->quantity;
                    $this->addIngredient($ingredients, 'chicken', $size, $chickenAmount);
                    $this->addIngredient($monthlySummary[$month], 'chicken', $size, $chickenAmount);
                }

                // 🍟 Fries
                if (str_contains($name, 'fries')) {
                    $type = $this->isWithBurger($order, $item)
                        ? 'with_burger'
                        : 'plate';

                    $amount = $rules['fries'][$type] * $item->quantity;
                    $this->addIngredient($ingredients, 'fries', $type, $amount);
                    $this->addIngredient($monthlySummary[$month], 'fries', $type, $amount);
                }
            }
        }

        return [$ingredients, $monthlySummary];
    }

    private function detectSize(string $name): string
    {
        return str_contains($name, 'small') ? 'small'
            : (str_contains($name, 'large') ? 'large' : 'medium');
    }

    private function isWithBurger($order, $friesItem): bool
    {
        foreach ($order->items as $item) {
            if (
                $item->id !== $friesItem->id &&
                str_contains(strtolower($item->product->name), 'burger')
            ) {
                return true;
            }
        }
        return false;
    }

    private function addIngredient(array &$arr, string $key, string $sub, float $amount): void
    {
        if (!isset($arr[$key])) {
            $arr[$key] = in_array($key, ['cheese','chicken'])
                ? ['small' => 0, 'medium' => 0, 'large' => 0, 'total' => 0]
                : ['plate' => 0, 'with_burger' => 0, 'total' => 0];
        }

        $arr[$key][$sub] += $amount;
        $arr[$key]['total'] += $amount;
    }
}
