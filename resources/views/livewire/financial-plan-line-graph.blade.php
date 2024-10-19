@php
    use App\Custom\FinanceUtils;
    use App\Custom\ColorUtils;
@endphp
<div class="col col-md-6 col-lg-3">
    <div class="card card-lightblue card-outline mb-0">
        <div class="card-header">
            <h3 class="card-title">{{ Str::ucfirst($subjectLabel) }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
              </div>
        </div>

        <div class="card-body pb-0">
            <div class="row">
                <div class="col pb-2"
                    x-data="{ chart: null }"
                    x-init="
                        const datasets = $wire.datasets;
                        datasets.forEach(dataset => {
                            const baseColorAlpha = dataset.borderColor.replace(/rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,?\s*(\d*\.?\d+)?\s*\)/, (_, r, g, b, a) => {
                                return `rgba(${r}, ${g}, ${b}, 0.5)`;
                            });

                            dataset.segment = {
                                borderDash: ctx => ctx.p0DataIndex >= dataset.dashStart ? [5, 7] : [],
                                borderColor: ctx => ctx.p0DataIndex >= dataset.dashStart ? baseColorAlpha : dataset.borderColor,
                            };
                        });

                        chart = new Chart(document.getElementById('comp-chart-line-{{ $subject }}').getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: $wire.labels,
                                datasets: $wire.datasets
                            },
                            options: {
                                maintainAspectRatio: false,
                                responsive: true,
                                interaction: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: { min: 0 }
                                }
                            }
                        });
                    "
                    >
                    <div class="height-graph height-sm-graph">
                        <canvas id="comp-chart-line-{{ $subject }}"></canvas>
                    </div>
                </div>
            </div>

            @if ($graphShowTable)
            <div class="col px-0">
                <table class="table table-bordered table-{{$size}} mx-0 px-0 ">
                    <tr>
                        <th class="bg-lightblue text-right text-{{$size}}">{{__('mpa.year')}}</th>
                        @foreach ($datasets as $ds)
                            <th class="bg-lightblue text-right text-{{$size}}">{{ $ds['label'] }}</th>
                        @endforeach
                    </tr>

                    @for($year = 0 ; $year < count($datasets[0]['data']); $year++)
                        @php
                            $highlightValue = $highlightId = null;
                            foreach ($datasets as $dsId => $ds) {
                                if (isset($ds['data'][$year])) {
                                    $currentValue = $ds['data'][$year];
                                    if ($highlightValue === null || ($isMax ? $currentValue > $highlightValue : $currentValue < $highlightValue)) {
                                        $highlightValue = $currentValue;
                                        $highlightId = $dsId;
                                    }
                                }
                            }
                        @endphp
                        <tr style="background-color: {{ ColorUtils::getColor($highlightId, 0.2); }}">
                            <td class="text-right text-{{$size}}">{{ $year+1 }}</td>
                            @foreach ($datasets as $index => $ds)
                            <td class="text-right text-{{$size}} @if(isset($ds['data'][$year]) && $ds['data'][$year] == $highlightValue) text-bold @endif">
                                    @isset($ds['data'][$year])
                                        @switch($units)
                                            @case('percentage')
                                                {{ FinanceUtils::formatDecimal( $ds['data'][$year] ) }}%
                                                @break
                                            @default
                                                {{ FinanceUtils::formatCurrency( $ds['data'][$year] ) }}
                                        @endswitch
                                    @endisset
                                </td>
                            @endforeach
                        </tr>
                    @endfor

                </table>
            </div>
            @endif

        </div>
    </div>

</div>
