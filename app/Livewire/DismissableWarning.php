<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DismissableWarning extends Component
{
    public $warningId;
    public $mt = 0;

    public function render()
    {
        return view('livewire.dismissable-warning');
    }

    public function dismiss()
    {
        session([$this->warningId => true]);
    }
}
