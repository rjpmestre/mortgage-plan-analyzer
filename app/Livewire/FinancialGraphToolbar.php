<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class FinancialGraphToolbar extends Component
{
    public $graphType = 0;
    public $graphTermMode = 0;
    public $graphShowTable = 0;

    public function render()
    {
        return view('livewire.financial-graph-toolbar');
    }

    public function updated($property, $value)
    {
        self::updatedGraphSettings();
    }

    public function toggleGraphShowTable()
    {
        $this->graphShowTable = !$this->graphShowTable;
        self::updatedGraphSettings();
    }

    public function updatedGraphSettings()
    {
        $this->dispatch('updated-graph-settings',
            graphType: $this->graphType,
            graphTermMode: $this->graphTermMode,
            graphShowTable: $this->graphShowTable
        );
    }
}
