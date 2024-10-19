@php
    use App\Custom\FinanceUtils;
    use App\Custom\ColorUtils;
@endphp
<div class="col col-md-6 col-lg-3">
    <div class="card card-lightblue card-outline mb-0">
        <div class="card-header">
            <h3 class="card-title">{{ __('mpa.comparing'). ' '.Str::ucfirst($subjectLabel).' '.__('mpa.per_year') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
              </div>
        </div>

        <div class="card-body pb-0">
            <div class="row">
                <div class="col pb-2"
                    x-data="{ chart: null }"
                    x-init="
                        chart = new Chart(document.getElementById('comp-chart-stack-' + $wire.subject).getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: $wire.labels,
                                datasets: $wire.datasets
                            },
                            options: {
                                maintainAspectRatio: false,
                                responsive: true,
                                scales: {
                                    x: { stacked: true },
                                    y: { stacked: true }
                                }
                            }
                        });
                    "
                    >
                    <div class="height-graph height-sm-graph">
                        <canvas id="comp-chart-stack-{{ $subject }}"></canvas>
                    </div>
                </div>
            </div>

            @if ($graphShowTable)
            <div class="col px-0">
                <table class="table table-bordered table-{{$size}} mx-0 px-0 ">
                    <tr>
                        <th class="bg-lightblue text-right text-{{$size}}">{{__('mpa.year')}} </th>
                        @foreach ($labels as $label)
                            <th class="bg-lightblue text-right text-{{$size}}">{{$label}}</th>
                        @endforeach
                    </tr>

                    @foreach($datasets as $index => $ds)
                        @php
                            $highlightValue = $highlightId = null;
                            foreach ($ds['data'] as $dsId => $dataValue){
                                if (isset($dataValue)) {
                                    $currentValue = $dataValue;
                                    if ($highlightValue === null || ($isMax ? $currentValue > $highlightValue : $currentValue < $highlightValue)) {
                                        $highlightValue = $currentValue;
                                        $highlightId = $dsId;
                                    }
                                }
                            }
                        @endphp
                        <tr style="background-color: {{ ColorUtils::getColor($highlightId, 0.2); }}">
                            <td class="text-right text-{{$size}}">{{ $ds['label'] }}</td>
                             @foreach ($ds['data'] as $dataValue)
                                <td class="text-right text-{{$size}} @if($dataValue == $highlightValue) text-bold @endif">
                                    @switch($units)
                                        @case('percentage')
                                            {{ FinanceUtils::formatDecimal( $dataValue ) }}%
                                            @break
                                        @default
                                            {{ FinanceUtils::formatCurrency( $dataValue ) }}
                                    @endswitch
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
            @endif

        </div>
    </div>

</div>
