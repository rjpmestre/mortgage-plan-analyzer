<?php

namespace App\Livewire;

use App\Custom\FinanceUtils;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use App\Custom\ColorUtils;
use App\Traits\FinancialGraphTrait;

class FinancialPlanLineGraph extends Component
{
    use FinancialGraphTrait;

    public function render()
    {
        $this->datasets = [];
        $this->labels = [];

        for($i = 0; $i < count($this->annualSummaries[0][$this->subject]); $i++){
            $this->labels[] = __('mpa.year') .' '. ($i+1);
        }

        foreach ($this->annualSummaries as $index => $data) {
            $dataset = [
                'label' => $this->scenarioNames[$index] ?? __('mpa.simulation') .' ' . (1+$index),
                'data' => $data[$this->subject],
                'cubicInterpolationMode' => 'monotone',
                'tension' => 0.4,
                'backgroundColor' => ColorUtils::getColor($index, 0.4),
                'borderColor' => ColorUtils::getColor($index, 1),
                'pointRadius' => 0,
                'pointHoverRadius' => 5,
                'dashStart' => $data['numberPaymentsFixedRate']/12,
            ];

            $this->datasets[] = $dataset;
        }

        return view('livewire.financial-plan-line-graph');
    }

}
