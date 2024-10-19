@php
    use App\Custom\FinanceUtils;
@endphp
<tr class="financial-plan-row" x-show="showPlan" x-transition>

    <th scope="col" class="text-right text-{{$size}} col-1">
        @if($i==0)
        {{ __('mpa.beginning') }}
        @elseif( $i == $maxPayments-1 )
        {{ __('mpa.total') }}
        @else
        {{ ceil($i/12) }} / {{ $i }}
        @endif
    </th>

    @foreach ($simulations as $index => $simulation)
        @if( isset($financialPlans[$index]) && isset($financialPlans[$index][$i]))
        @php
            $payment = $financialPlans[$index][$i];
            $extraClass = $i != count($financialPlans[$index])-1 ? '' : 'last';
        @endphp
        <td class="text-right text-{{$size}} {{ $extraClass }}">
            @isset($payment['payment'])
                {{ FinanceUtils::formatCurrency( $payment['payment']) }}
            @endisset
        </td>
        <td class="text-right text-{{$size}} {{ $extraClass }}">
            @isset($payment['principal'])
                {{ FinanceUtils::formatCurrency( $payment['principal']) }}
            @endisset
        </td>
        <td class="text-right text-{{$size}} {{ $extraClass }}">
            @isset($payment['interest'])
                {{ FinanceUtils::formatCurrency( $payment['interest']) }}
            @endisset
        </td>
        <td class="text-right text-{{$size}} {{ $extraClass }}">
            @isset($payment['debt'])
                {{ FinanceUtils::formatCurrency( $payment['debt']) }}
            @endisset
        </td>
        <td class="text-right text-{{$size}} {{ $extraClass }}">
            @isset($payment['tan'])
                {{ FinanceUtils::round( $payment['tan'], 4) }}%
            @endisset
        </td>
        @else
            <td colspan="5"></td>
        @endisset
    @endforeach
    </tr>

</tr>
