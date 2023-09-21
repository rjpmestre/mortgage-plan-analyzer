<?php

namespace App\Livewire;

use App\Custom\FinanceUtils;
use App\Custom\Simulation;
use App\Custom\EuriborAcquisitor;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Illuminate\Support\Str;

class SimManager extends Component
{
    protected $rules = [
            "simulations.*.loanAmount" => 'required|decimal:0,2|min:0|max:999999999.99',
            "simulations.*.numberPaymentsFixedRate" => 'required|integer|min:0|max:720',
            "simulations.*.annualInterestFixedRate" => 'required|decimal:0,4|min:0.00|max:99.99',
            "simulations.*.numberPaymentsVariableRate" => 'required|integer|min:0|max:720',
            "simulations.*.spread" => 'required|decimal:0,4|min:0.00|max:99.99',
            "simulations.*.referenceVariableRate" => 'required|decimal:0,4|min:-99.99|max:99.99',
    ];

    // multiple simulations inputs
    #[Url]
    public $simulations = [];

    // keep track of the payments for each simulation
    public $financialPlans = [];

    // keep track of annual summaries for each simulation (short/medium term)
    public $annualSummaries = [];

    public $euribor = 0;

    public function mount()
    {
        $this->euribor = (new EuriborAcquisitor())->getEuribor12M();

        if(empty($this->simulations)){
            $this->addSimulation();
        }else{
            foreach($this->simulations as $index => $simulation){
                $this->calculatePayments($index);
            }
        }

    }

    public function render()
    {
        $maxPayments = empty($this->financialPlans) ? 0 :
            max(array_map(fn($array) => count($array), $this->financialPlans));

        return view('livewire.sim-manager', [
            'maxPayments' => $maxPayments,
        ]);
    }

    #[On('addSimulation')]
    public function addSimulation()
    {
        if(empty($this->simulations)){
            $this->simulations[] = [
                'id' => uniqid(),
                'loanAmount' => 0,
                'numberPaymentsFixedRate' => 0,
                'annualInterestFixedRate' => 0,
                'numberPaymentsVariableRate' => 0,
                'spread' => 0,
                'referenceVariableRate' => $this->euribor,
            ];
        }
        else{
            $this->simulations[] = end($this->simulations);
        }

        $this->calculatePayments(count($this->simulations)-1);
    }

    public function removeSimulation($index)
    {
        unset($this->simulations[$index]);
        $this->simulations = array_values($this->simulations);

        unset($this->financialPlans[$index]);
        $this->financialPlans = array_values($this->financialPlans);

        unset($this->annualSummaries[$index]);
        $this->annualSummaries = array_values($this->annualSummaries);
    }

    public function updated($propertyName, $value)
    {
        $this->validate();
        if (Str::startsWith($propertyName, 'simulations.')) {
            $this->calculatePayments(explode('.', $propertyName)[1]);
        }
    }

    private function calculatePayments($index)
    {
        $simulation = new Simulation(
            $this->simulations[$index]['loanAmount'],
            $this->simulations[$index]['numberPaymentsFixedRate'],
            $this->simulations[$index]['annualInterestFixedRate'],
            $this->simulations[$index]['numberPaymentsVariableRate'],
            $this->simulations[$index]['spread'],
            $this->simulations[$index]['referenceVariableRate']
        );

        $this->financialPlans[$index] = collect($simulation->payments)->map(function ($payment) {
            $outputEntry = [];

            if(isset($payment->title)){
                $outputEntry['title'] = $payment->title;
            }

            if(isset($payment->payment)){
                $outputEntry['payment'] = FinanceUtils::round($payment->payment);
            }

            if(isset($payment->principal)){
                $outputEntry['principal'] = FinanceUtils::round($payment->principal);
            }

            if(isset($payment->interest)){
                $outputEntry['interest'] = FinanceUtils::round($payment->interest);
            }

            if(isset($payment->debt)){
                $outputEntry['debt'] = FinanceUtils::round($payment->debt);
            }

            if(isset($payment->tan)){
                $outputEntry['tan'] = FinanceUtils::round($payment->tan, 4);
            }

            return $outputEntry;

        })->all();

        $this->annualSummaries[$index] = $simulation->annualSummaries;
    }


}
