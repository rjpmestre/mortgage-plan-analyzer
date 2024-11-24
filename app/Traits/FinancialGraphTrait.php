<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Carbon\Carbon;
use Livewire\Attributes\Reactive;

trait FinancialGraphTrait
{
    #[Reactive]
    public $annualSummaries;

    #[Reactive]
    public $scenarioNames;

    public $size;
    public $graphShowTable;

    public $subject;
    public $subjectLabel;
    public $isMax;
    public $units = "euro";

    public $labels;
    public $datasets;

}
