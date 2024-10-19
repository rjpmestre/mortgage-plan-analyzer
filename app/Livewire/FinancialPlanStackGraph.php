<?php

namespace App\Livewire;

use App\Custom\FinanceUtils;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use App\Custom\ColorUtils;
use App\Traits\FinancialGraphTrait;

class FinancialPlanStackGraph extends Component
{
    use FinancialGraphTrait;

    #[Reactive]
    public $annualSummaries;

    #[Reactive]
    public $scenarioNames;

    public $size;

    public $subject;
    public $subjectLabel;
    public $isMax;
    public $units = "euro";

    public $labels;
    public $datasets;

    public function render()
    {
        $this->datasets = [];
        $this->labels = [];

        foreach ($this->scenarioNames as $index => $name) {
            $this->labels[] = $name ?? __('mpa.simulation') .' '. (1+$index);
        }

        $transposedData = array_map(null, ...array_column($this->annualSummaries, $this->subject));

        foreach ($transposedData as $index => $data) {
            $dataset = [
                'label' => ($index + 1),
                'data' => is_array($data) ? $data : [$data],
                'backgroundColor' => ColorUtils::getColor($index, 0.4),
                'borderColor' => ColorUtils::getColor($index, 1)
            ];

            $this->datasets[] = $dataset;
        }
        return view('livewire.financial-plan-stack-graph');
    }

    public function updated($propertyName, $value)
    {
    }


}
