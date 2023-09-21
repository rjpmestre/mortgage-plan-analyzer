@php
    use App\Custom\FinanceUtils;
    use App\Custom\ColorUtils;
@endphp
<div
    x-data="{ chart: null }"
    x-init="
        chart = new Chart(document.getElementById('comp-chart-' + $wire.subject).getContext('2d'), {
            type: 'bar',
            data: {
                labels: $wire.labels,
                datasets: $wire.datasets
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Comparativo de ' + $wire.subjectLabel,
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true }
                }
            }
        });
    "
>
    <canvas id="comp-chart-{{ $subject }}" style="height:200px" width="400"></canvas>

    <h4>{{ Str::ucfirst($subjectLabel) }}</h4>
    <table class="table table-bordered table-sm">
        <tr>
            <th class="text-right">Ano</th>
            @foreach (array_keys($annualSummaries) as $index)
                <th class="text-right">Simulação {{ $index }}</th>
            @endforeach
        </tr>
        @for($year =0 ; $year<4; $year++)
            <tr style="background-color: {{ ColorUtils::getColor($year, 0.2); }}">
                <td class="text-right">{{ $year+1 }}</td>
                @foreach ($annualSummaries as $index => $annualSummary)
                    <td class="text-right">
                        @isset($annualSummary[$subject][$year])
                            @switch($units)
                                @case('percentage')
                                    {{ FinanceUtils::formatDecimal( $annualSummary[$subject][$year]) }}%
                                    @break
                                @default
                                    {{ FinanceUtils::formatCurrency( $annualSummary[$subject][$year]) }}
                            @endswitch
                        @endisset
                    </td>
                @endforeach
            </tr>
        @endfor

    </table>
</div>

