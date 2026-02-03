<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',          // always in base unit (g, ml, pcs)
        'unit',              // user-friendly unit: kg, liter, pcs
        'base_unit',         // base unit: g, ml, pcs
        'conversion_factor', // 1 kg = 1000 g, 1 l = 1000 ml
        'description',
        'price',
    ];

    /**
     * Deduct quantity from stock
     */
    public function deduct(float $amount, ?string $unit = null): bool
    {
        $amountInBase = $this->toBase($amount, $unit);

        if ($this->quantity >= $amountInBase) {
            $this->quantity -= $amountInBase;
            return $this->save();
        }

        return false;
    }

    /**
     * Add quantity to stock
     */
    public function add(float $amount, ?string $unit = null): bool
    {
        $amountInBase = $this->toBase($amount, $unit);
        $this->quantity += $amountInBase;
        return $this->save();
    }

    /**
     * Convert a value to base unit
     */
    public function toBase(float $amount, ?string $unit = null): float
    {
        // if unit not provided, use model's unit
        $unit = $unit ?? $this->unit;

        return match($unit) {
            'kg' => $amount * 1000,
            'liter' => $amount * 1000,
            'g', 'ml', 'pcs' => $amount,
            default => $amount,
        };
    }

    /**
     * Display quantity as: 2 kg (2000 g)
     */
    public function displayQuantity(): string
    {
        return match ($this->unit) {
            'kg' => $this->formatKg(),
            'liter' => $this->formatLiter(),
            'g', 'ml' => number_format($this->quantity, 0) . " {$this->unit}",
            'pcs' => (int)$this->quantity . " pcs",
            default => $this->quantity . " {$this->unit}",
        };
    }

    private function formatKg(): string
    {
        $kg = $this->quantity / 1000;
        return rtrim(rtrim(number_format($kg, 2), '0'), '.') . " kg"
            . " (" . number_format($this->quantity, 0) . " g)";
    }

    private function formatLiter(): string
    {
        $liter = $this->quantity / 1000;
        return rtrim(rtrim(number_format($liter, 2), '0'), '.') . " l"
            . " (" . number_format($this->quantity, 0) . " ml)";
    }

    public function getQuantityInDisplayUnit(): float
{
    return match ($this->unit) {
        'kg' => $this->quantity / 1000,
        'liter' => $this->quantity / 1000,
        default => $this->quantity,
    };
}

}
