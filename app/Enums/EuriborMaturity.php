<?php

namespace App\Enums;

use Illuminate\Support\Facades\Log;

enum EuriborMaturity: string {
    case EURIBOR_12M = '12m';
    case EURIBOR_6M = '6m';
    case EURIBOR_3M = '3m';
    case EURIBOR_1M = '1m';
}
