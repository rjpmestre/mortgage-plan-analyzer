<?php

namespace App\Custom;

use App\Custom\FinanceUtils;
use Illuminate\Support\Facades\Log;


class Payment
{
    public $title;
    public float $tan;
    public float $rate;
    public float $payment;
    public float $principal;
    public float $interest;
    public float $debt;
    public float $total;

    public function calculate(
        float $debt,
        float $rate,
        int $remainingPayments,
    ){
        //
        $this->rate = $rate;

        // calc interest
        $this->interest = FinanceUtils::round($debt * $rate);

        // calc payment
        $this->payment = FinanceUtils::pmt($rate, $remainingPayments, $debt);

        // calc principal
        $this->principal = FinanceUtils::round($this->payment-$this->interest);

        // calc debt
        $this->debt = FinanceUtils::round($debt-$this->principal);
    }
}
