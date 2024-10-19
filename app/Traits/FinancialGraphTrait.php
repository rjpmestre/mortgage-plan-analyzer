<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Carbon\Carbon;

trait FinancialGraphTrait
{
    #[Url]
    public $graphType = 0;

    #[Url]
    public $graphTermMode = 0;

    #[Url]
    public $graphShowTable = 0;

    public $term = 10;


    #[On('updated-graph-settings')]
    public function updatedGraphType($graphType, $graphTermMode, $graphShowTable){
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

}
