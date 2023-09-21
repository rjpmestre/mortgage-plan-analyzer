<?php

namespace App\Livewire;

use App\Custom\FinanceUtils;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;
use App\Custom\ColorUtils;

class FinancialPlanStackGraph extends Component
{
    #[Reactive]
    public $annualSummaries;

    public $subject;
    public $subjectLabel;
    public $units = "euro";

    public $labels;
    public $datasets;

    public function render()
    {
        $this->datasets = [];

        $this->labels = array_map(function ($index) {
            return 'Scenario ' . $index;
        }, array_keys($this->annualSummaries));

        $transposedData = array_map(null, ...array_column($this->annualSummaries, $this->subject));

        foreach ($transposedData as $index => $data) {
            $dataset = [
                'label' => 'Ano ' . ($index + 1),
                'data' => is_array($data) ? $data : [$data],
                'backgroundColor' => ColorUtils::getColor($index, 0.4),
                'borderColor' => ColorUtils::getColor($index, 1)
            ];

            $this->datasets[] = $dataset;
        }

        return view('livewire.financial-plan-stack-graph');
    }



}
