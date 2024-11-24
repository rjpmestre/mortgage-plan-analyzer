<div wire:key="simulations" class="pt-2">

    <div wire:loading class="loading">
         <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="row">
        <div class="col card-row card px-0" >
            <div class="card-header">
                <div class="card-tools">
                    <livewire:financial-graph-toolbar />
                </div>
            </div>
            <div class="card-body px-0 py-0 ">
                @if(!empty($annualSummaries) && !empty($annualSummaries[0]['payment']))
                    <div class="row">
                        @switch($graphType)
                            @case(1)
                                <livewire:financial-plan-line-graph     :$annualSummaries :$scenarioNames key="{{ now() }}" subject="payment" subject_label="{{ __('mpa.installments') }}" :$size :$graphShowTable :isMax=false />
                                <livewire:financial-plan-line-graph     :$annualSummaries :$scenarioNames key="{{ now() }}" subject="principal" subject_label="{{ __('mpa.amortizations') }}" :$size :$graphShowTable :isMax=true />
                                <livewire:financial-plan-line-graph     :$annualSummaries :$scenarioNames key="{{ now() }}" subject="interest" subject_label="{{ __('mpa.interest') }}" :$size :$graphShowTable :isMax=false />
                                <livewire:financial-plan-line-graph     :$annualSummaries :$scenarioNames key="{{ now() }}" subject="percentagePrincipal" subject_label="{{ __('mpa.perc_amortizations_payment') }}" units="percentage" :$size :$graphShowTable :isMax=true />
                                @break
                            @case(2)
                                <livewire:financial-plan-line-acc-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="payment" subject_label="{{ __('mpa.installments') }}" :$size :$graphShowTable :isMax=false />
                                <livewire:financial-plan-line-acc-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="principal" subject_label="{{ __('mpa.amortizations') }}" :$size :$graphShowTable :isMax=true />
                                <livewire:financial-plan-line-acc-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="interest" subject_label="{{ __('mpa.interest') }}" :$size :$graphShowTable :isMax=false />
                                <livewire:financial-plan-line-graph     :$annualSummaries :$scenarioNames key="{{ now() }}" subject="percentagePrincipal" subject_label="{{ __('mpa.perc_amortizations_payment') }}" units="percentage" :$size :$graphShowTable :isMax=true />
                                @break
                            @default
                                <livewire:financial-plan-stack-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="payment" subject_label="{{ __('mpa.installments') }}" :$size :$graphShowTable :isMax=false />
                                <livewire:financial-plan-stack-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="principal" subject_label="{{ __('mpa.amortizations') }}" :$size :$graphShowTable :isMax=true />
                                <livewire:financial-plan-stack-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="interest" subject_label="{{ __('mpa.interest') }}" :$size :$graphShowTable :isMax=false />
                                <livewire:financial-plan-stack-graph :$annualSummaries :$scenarioNames key="{{ now() }}" subject="percentagePrincipal" subject_label="{{ __('mpa.perc_amortizations_payment') }}" units="percentage" :$size :$graphShowTable :isMax=true />
                        @endswitch
                    </div>

                    @if($graphType > 0)
                        <livewire:dismissable-warning :warningId="'graphs_dash_line_warning'" :mt=3 />
                    @endif
                    @if($graphShowTable > 0)
                        <livewire:dismissable-warning :warningId="'graphs_table_highlights_warning'" :mt="$graphType > 0 && !session('graphs_dash_line_warning') ? 0 : 3" />
                    @endif

                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col card card-lightblue card-outline px-0 py-0" x-data="{ showPlan: @entangle('showPlan') }">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">{{ __('mpa.simulations') }}</h3>

                <div class="card-tools">
                    @if(count($simulations)<3)
                        <button type="button" class="btn btn-outline-secondary btn-{{$size}}"  wire:click="addSimulation()">
                            <i class="fas fa-plus"></i> <span>{{ __('mpa.simulation_add') }}</span>
                        </button>
                    @endif

                    <button type="button" class="btn btn-outline-secondary btn-{{$size}}" @click="showPlan = ! showPlan">
                        <i class="fas fa-table-list"></i> <span x-show="showPlan">{{ __('mpa.financial_plan_hide') }}</span> <span x-show="!showPlan">{{ __('mpa.financial_plan_show') }}</span>
                    </button>

                </div>
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered table-hover mx-0 px-0 table-{{$size}}" id="tableSimulations" >
                    <tr>
                        <th scope="row" class="text-right text-{{$size}}">{{ __('mpa.simulation') }}</th>
                        @foreach ($simulations as $index => $simulation)
                        <td colspan="5" class="p-0">
                            <div class="input-group align-items-center">
                                <input type="text" class="form-control simInput text-{{$size}}" id="inputName"
                                    wire:model.live.debounce.1000ms="simulations.{{ $index }}.name" placeholder="{{ __('mpa.name_hint') }}...">
                                <div class="card-tools">
                                    @if(count($simulations)<3)
                                        <span class="btn btn-tool btn-{{$size}} pr-0" wire:click="addSimulation('{{ $index }}')"
                                            alt="{{ __('mpa.simulation_clone_hint') }}" title="{{ __('mpa.simulation_clone_hint') }}">
                                        <i class="fas fa-clone"></i>
                                        </span>
                                    @endif
                                    <span class="btn btn-tool btn-{{$size}}" wire:click="removeSimulation('{{ $index }}')"
                                    wire:confirm="{{ __('mpa.simulation_remove_confirm') }}"
                                    alt="{{ __('mpa.simulation_remove_hint') }}" title="{{ __('mpa.simulation_remove_hint') }}">
                                    <i class="fas fa-times"></i>
                                    </span>
                                </div>
                            </div>
                            @error("simulations.$index.loanAmount") <span class="text-danger">{{ $message }}</span> @enderror
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="row" class="text-right text-{{$size}}" alt="{{ __('mpa.amount_hint') }}" title="{{ __('mpa.amount_hint') }}">
                            {{ __('mpa.amount') }}<span class="text-danger">*</span></th>
                        @foreach ($simulations as $index => $simulation)
                            <td colspan="5" class="p-0">
                                <div class="input-group align-items-center">
                                    <input type="number" class="form-control simInput text-{{$size}}" id="inputLoanAmount"
                                        wire:model.live.debounce.1000ms="simulations.{{ $index }}.loanAmount" placeholder="{{ __('mpa.amount_hint') }}...">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-euro fa-{{$size}}"></i></span>
                                    </div>
                                </div>
                                @error("simulations.$index.loanAmount") <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="row" class="text-right text-{{$size}}" alt="{{ __('mpa.term_fixed_hint') }}" title="{{ __('mpa.term_fixed_hint') }}">
                            {{ __('mpa.term_fixed') }}<span class="text-danger">*</span>
                        </th>
                        @foreach ($simulations as $index => $simulation)
                            <td colspan="5" class="p-0">
                                <input type="number" step="1" class="form-control simInput text-{{$size}}" id="inputNumberPaymentsFixedRate"
                                    wire:model.live.debounce.1000ms="simulations.{{ $index }}.numberPaymentsFixedRate"
                                    placeholder="{{ __('mpa.term_fixed_hint') }}...">
                                @error("simulations.$index.numberPaymentsFixedRate") <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                        @endforeach
                    </tr>
                    <tr> <th scope="row" class="text-right text-{{$size}}" alt="{{ __('mpa.fixed_rate_hint') }}" title="{{ __('mpa.fixed_rate_hint') }}">
                        {{ __('mpa.fixed_rate') }}<span class="text-danger">*</span></th>
                        @foreach ($simulations as $index => $simulation)
                            <td colspan="5" class="p-0">
                                <div class="input-group align-items-center">
                                    <input type="number" step="1" class="form-control simInput text-{{$size}}" id="inputAnnualInterestFixedRate"
                                        wire:model.live.debounce.1000ms="simulations.{{ $index }}.annualInterestFixedRate"
                                        placeholder="{{ __('mpa.fixed_rate_hint') }}...">
                                    <div class="input-group-append text-xl">
                                        <span class="input-group-text"><i class="fas fa-percent fa-{{$size}}"></i></span>
                                    </div>
                                </div>
                                @error("simulations.$index.annualInterestFixedRate") <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="row" class="text-right text-{{$size}}" alt="{{ __('mpa.variable_rate_hint') }}" title="{{ __('mpa.variable_rate_hint') }}">
                            {{ __('mpa.variable_rate') }}<span class="text-danger">*</span></th>
                        @foreach ($simulations as $index => $simulation)
                            <td colspan="5" class="p-0">
                                <input type="number" step="1" class="form-control simInput text-{{$size}}" id="inputNumberPaymentsVariableRate"
                                    wire:model.live.debounce.1000ms="simulations.{{ $index }}.numberPaymentsVariableRate"
                                    placeholder="{{ __('mpa.variable_rate_hint') }}...">
                                @error("simulations.$index.numberPaymentsVariableRate") <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="row" class="text-right text-{{$size}}" alt="{{ __('mpa.contracted_spread_hint') }}" title="{{ __('mpa.contracted_spread_hint') }}">
                            {{ __('mpa.contracted_spread') }}
                            <span class="text-danger">*</span>
                            <br/>
                            <small>{{ __('mpa.euribor_12m') }}:  <b>{{ $euribor }}%</b></small>
                        </th>
                        @foreach ($simulations as $index => $simulation)
                            <td colspan="5" class="p-0">
                                <div class="input-group align-items-center">
                                    <input type="number" step="1" class="form-control simInput text-{{$size}}" id="inputSpread"
                                        wire:model.live.debounce.1000ms="simulations.{{ $index }}.spread"
                                        placeholder="{{ __('mpa.contracted_spread_hint') }}...">
                                    <div class="input-group-append">
                                        <span class="input-group-text "><i class="fas fa-percent fa-{{$size}}"></i></span>
                                    </div>
                                </div>
                                @error("simulations.$index.spread") <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                        @endforeach
                    </tr>

                    @if(!empty($financialPlans))
                        <tr class="blank_row financial-plan-row" x-show="showPlan" x-transition>
                            <td colspan="{{ count($simulations) * 5 + 1  }}">&nbsp;</td>
                        </tr>

                        <tr class="financial-plan-row-header" x-show="showPlan" x-transition>
                            <th scope="col" class="bg-lightblue text-right text-{{$size}}">{{ mb_strtoupper(__('mpa.year'))}} / {{mb_strtoupper(__('mpa.installment'), 'UTF-8')}}</th>
                            @foreach ($simulations as $index => $simulation)
                                @isset($financialPlans[$index])
                                    <th scope="col" class="bg-lightblue text-right text-{{$size}}">{{ mb_strtoupper(__('mpa.monthly_installment'))}}</th>
                                    <th scope="col" class="bg-lightblue text-right text-{{$size}}">{{ mb_strtoupper(__('mpa.capital_amortization'))}}</th>
                                    <th scope="col" class="bg-lightblue text-right text-{{$size}}">{{ mb_strtoupper(__('mpa.interest'))}}</th>
                                    <th scope="col" class="bg-lightblue text-right text-{{$size}}">{{ mb_strtoupper(__('mpa.outstanding_capital'))}}</th>
                                    <th scope="col" class="bg-lightblue text-right text-{{$size}}">{{ mb_strtoupper(__('mpa.apr'))}}</th>
                                @else
                                    <th colspan="5"/>
                                @endisset
                            @endforeach
                        </tr>

                        @for ($i = 0; $i<$maxPayments; $i++)
                            @include('financial-plan-row', ['simulations'=>$simulations, 'financialPlans' => $financialPlans, 'i' => $i, 'maxPayments' => $maxPayments, 'size' => $size , 'showPlan' => $showPlan])
                        @endfor

                    @endif


                </table>

            </div>
        </div>
    </div>
</div>
