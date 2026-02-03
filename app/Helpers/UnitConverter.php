<?php

namespace App\Helpers;

class UnitConverter
{
    public static function toBaseUnit($quantity)
    {
        $quantity = strtolower(trim($quantity));

        if (strpos($quantity, 'kg') !== false) {
            return floatval($quantity) * 1000; // kg -> grams
        } elseif (strpos($quantity, 'g') !== false) {
            return floatval($quantity); // grams
        } elseif (strpos($quantity, 'l') !== false) {
            return floatval($quantity) * 1000; // liters -> ml
        } elseif (strpos($quantity, 'ml') !== false) {
            return floatval($quantity); // ml
        } else {
            return floatval($quantity); // assume pieces
        }
    }

    public static function getUnit($quantity)
    {
        $quantity = strtolower(trim($quantity));
        if (strpos($quantity, 'kg') !== false || strpos($quantity, 'g') !== false) return 'g';
        if (strpos($quantity, 'l') !== false || strpos($quantity, 'ml') !== false) return 'ml';
        return 'piece';
    }
}
