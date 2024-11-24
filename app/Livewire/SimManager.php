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

use function PHPUnit\Framework\isEmpty;

class SimManager extends Component
{
    public $graphType = 0;
    public $graphTermMode = 0;
    public $graphShowTable = 0;
    public $term = 10;

    public $size ="sm";

    #[Url]
    public $showPlan = true;

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

    // keep track of annual summaries for each simulation
    public $annualSummaries = [];
    public $scenarioNames = [];


    public $euribor = 0;

    //
    private $simulationsArray = [];

    public function mount()
    {
        $this->euribor = (new EuriborAcquisitor())->getEuribor12M();
        self::updatedGraphSettings($this->graphType, $this->graphTermMode, $this->graphShowTable);

        if (empty($this->simulations)){
            $this->addSimulation();
        } else {
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

    #[On('updated-graph-settings')]
    public function updatedGraphSettings($graphType, $graphTermMode, $graphShowTable){
        $this->graphType = $graphType;
        $this->graphTermMode = $graphTermMode;
        $this->graphShowTable = $graphShowTable;
        switch ($graphTermMode) {
            case 0:
                $this->term = 10;
                break;
            case 1:
                $this->term = 20;
                break;
            default:
                $this->term = 100;
                break;
        }
        self::updated(null, null);
    }

    #[On('addSimulation}')]
    public function addSimulation($id = null)
    {
        $simulation = isset($id) && isset($this->simulations[$id])
        ? $this->simulations[$id]
        : [
            'id' => uniqid(),
            'name' => 'Sim ' . (count($this->simulations) + 1),
            'loanAmount' => 0,
            'numberPaymentsFixedRate' => 0,
            'annualInterestFixedRate' => 0,
            'numberPaymentsVariableRate' => 0,
            'spread' => 0,
            'referenceVariableRate' => $this->euribor
        ];

        if (isset($id) && isset($simulation['name'])){
            $simulation['name'] = $simulation['name'] . ' copy';
        }

        $this->simulations[] = $simulation;
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

        unset($this->simulationsArray[$index]);
        unset($this->scenarioNames[$index]);
        $this->scenarioNames = array_values($this->scenarioNames);
    }

    public function updated($propertyName, $value)
    {
        $this->validate();

        if (Str::startsWith($propertyName, 'simulations.')) {
            $index = explode('.', $propertyName)[1];
            $this->calculatePayments($index);
        } else {
            foreach($this->simulations as $index => $simulation){
                $this->calculatePayments($index);
            }
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
            $this->simulations[$index]['referenceVariableRate'],
            $this->term
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

        $this->simulationsArray[$index] = $simulation;
        $this->updateSummary($index);
    }

    private function updateSummary($index)
    {
        $payments =  $this->simulationsArray[$index]->payments;

        $annualSummaries = [];

        // remove initial and total rows
        array_shift($payments);
        array_pop($payments);

        // slice to summaries term & group them in years
        $payments = array_slice($payments, 0, $this->term * 12);
        $yearEntries = array_chunk($payments, 12);

        $annualSummaries['payment'] = array_map(function ($chunk) {
            return FinanceUtils::round(array_sum(array_column($chunk, 'payment')), 2);
        }, $yearEntries);

        $annualSummaries['interest'] = array_map(function ($chunk) {
            return FinanceUtils::round(array_sum(array_column($chunk, 'interest')), 2);
        }, $yearEntries);

        $annualSummaries['principal'] = array_map(function ($chunk) {
            return FinanceUtils::round(array_sum(array_column($chunk, 'principal')), 2);
        }, $yearEntries);

        $annualSummaries['percentagePrincipal'] = array_map(function ($chunk) {
            $totalPrincipal = array_sum(array_column($chunk, 'principal'));
            $totalPayment = array_sum(array_column($chunk, 'payment'));

            if($totalPayment==0){
                return 0;
            }
            return FinanceUtils::round($totalPrincipal * 100 / $totalPayment);
        }, $yearEntries);

        $annualSummaries['numberPaymentsFixedRate'] = $this->simulationsArray[$index]->numberPaymentsFixedRate;

        $this->annualSummaries[$index] = $annualSummaries;
        $this->scenarioNames = array_map(function($item) {
            return $item['name'] ?? null; // Return 'name' if exists, otherwise null
        }, $this->simulations);
    }

    public function toggleShowPlan()
    {
        $this->showPlan = !$this->showPlan;
    }

    public function resetDismissedSessionWarning()
    {
        session(['graphs_dash_line_warning' => false]);
        session(['graphs_table_highlights_warning' => false]);
    }

}
