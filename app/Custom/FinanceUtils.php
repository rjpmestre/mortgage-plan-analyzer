<?php

namespace App\Custom;

class FinanceUtils
{
    /**
     * Calculate the monthly payment for a loan.
     * @param float $rate The interest rate for the loan.
     * @param int $nper The number of payments left.
     * @param float $pv Current debt value.
     */
    public static function pmt(float $rate, int $nper, float $pv): float
    {
        // Calculate the PMT using the formula
        if ($rate > 0) {
            $pmt = ($pv * ($rate * pow(1 + $rate, $nper))) / (pow(1 + $rate, $nper) - 1);
        } else {
            // If the monthly rate is 0, handle it separately to avoid division by zero
            $pmt = $pv / $nper;
        }

        return $pmt; // Return a positive value for the payment amount
    }

    public static function formatCurrency($amount, $precision = 2)
    {
        return number_format($amount, $precision, ',', '.').'€';
    }

    public static function formatDecimal($amount, $precision = 2)
    {
        return number_format($amount, $precision, ',', '.');
    }

    public static function round(float $amount, int $precision = 2): float
    {
        return round($amount, $precision, PHP_ROUND_HALF_EVEN);
    }
}
