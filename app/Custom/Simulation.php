<?php

namespace App\Custom;

use App\Custom\Payment;
use Illuminate\Support\Facades\Log;

class Simulation
{
    private int $precision = 8;
    public  int $numberPaymentsFixedRate;
    public $payments;
    public $annualSummaries;

    public function __construct(
        float $loanAmount,
        int $numberPaymentsFixedRate,
        float $annualInterestFixedRate,
        int $numberPaymentsVariableRate,
        float $spread,
        float $referenceVariableRate
    ){
        $debt =  $loanAmount;

        $this->numberPaymentsFixedRate = $numberPaymentsFixedRate;

        $ratePerPayment = $this->getRatePerPayment(
            $numberPaymentsFixedRate,
            $annualInterestFixedRate,
            $numberPaymentsVariableRate,
            $spread,
            $referenceVariableRate
        );

        // initial row
        $initialRow = new Payment();
        $initialRow->title = 'Início';
        $initialRow->debt = $debt;
        $this->payments[] = $initialRow;

        // total row
        $totalsRow = new Payment();
        $totalsRow->principal = 0;
        $totalsRow->interest = 0;
        $totalsRow->payment = 0;
        $totalsRow->title = 'Total';
        $totalsRow->debt = $debt;

        $totalPayments = $numberPaymentsFixedRate + $numberPaymentsVariableRate;
        // monthly payments & annual totals
        for ($i = 0; $i < $totalPayments; $i++) {
            // montly payment
            $payment = new Payment();
            $payment->tan = $i<$numberPaymentsFixedRate? $annualInterestFixedRate: $referenceVariableRate + $spread;
            $payment->title = $i+1;
            $payment->calculate($debt, $ratePerPayment[$i], $totalPayments-$i);
            $this->payments[] = $payment;

            // update debt
            $debt = $payment->debt;

            // update totals
            $totalsRow->principal += $payment->principal;
            $totalsRow->interest += $payment->interest;
            $totalsRow->payment += $payment->payment;
        }

        $this->payments[] = $totalsRow;
    }

    private function getRatePerPayment(
        int $numberPaymentsFixedRate,
        float $annualInterestFixedRate,
        int $numberPaymentsVariableRate,
        float $spread,
        float $referenceVariableRate
    ){
        $rates = [];
        $fixedRate  = ($annualInterestFixedRate) ? FinanceUtils::round($annualInterestFixedRate / 12 / 100, $this->precision) : 0;
        $variableRate  = FinanceUtils::round(($referenceVariableRate + $spread) / 12 / 100, $this->precision);

        for($i=0; $i<$numberPaymentsFixedRate; $i++){
            $rates[] = $fixedRate;
        }

        for($i=0; $i<$numberPaymentsVariableRate; $i++){
            $rates[] = $variableRate;
        }

        return $rates;
    }

}
