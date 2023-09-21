<div wire:key="simulations" class="row">
    <div wire:loading class="loading">
         <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    @if(!empty($annualSummaries))
        <div class="col-3 card card-outline">
            <div class="card-body">
                <livewire:financial-plan-stack-graph :$annualSummaries key="{{ now() }}" subject="payment" subject_label="Prestações"/>
            </div>
        </div>
        <div class="col-3 card card-outline">
            <div class="card-body">
                <livewire:financial-plan-stack-graph :$annualSummaries key="{{ now() }}" subject="principal" subject_label="Amortizações"/>
            </div>
        </div>
        <div class="col-3 card card-outline">
            <div class="card-body">
                <livewire:financial-plan-stack-graph :$annualSummaries key="{{ now() }}" subject="interest" subject_label="Juros"/>
            </div>
        </div>
        <div class="col-3 card card-outline">
            <div class="card-body">
                <livewire:financial-plan-stack-graph :$annualSummaries key="{{ now() }}" subject="percentagePrincipal" subject_label="% nas Amortizações" units="percentage"/>
            </div>
        </div>
    @endif

    <div class="col-12 card card-outline px-0">
        <div class="card-body px-0">

            <table class="table table-bordered table-hover mx-0 px-0 table-sm" id="tableSimulations">
                <tr>
                    <th scope="row" class="text-right" style="white-space: nowrap">Simulação</th>
                    @foreach ($simulations as $index => $simulation)
                        <td colspan="5" class="pl-3">
                            {{ $index }}
                            <button
                                type="button"
                                wire:click="removeSimulation('{{ $index }}')"
                                wire:confirm="Are you sure you want to remove this simulation?"
                                class="float-right btn btn-box-tool py-0 my-0">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    @endforeach

                    @if(count($simulations)<3)
                    <td rowspan="{{ 8 + $maxPayments }}" class="text-center py-4 addnew col-1 text-white" style="white-space: nowrap" wire:click="addSimulation">
                            <i class="fas fa-xl fa-plus-circle" ></i>
                            <p><b>Add Simulation</b></p>
                    </td>
                    @endif
                </tr>
                <tr>
                     <th scope="row" class="text-right" style="white-space: nowrap">Montante <span class="text-danger">*</span></th>
                    @foreach ($simulations as $index => $simulation)
                        <td colspan="5">
                            <div class="input-group">
                                <input type="number" class="form-control simInput" id="inputLoanAmount"
                                    wire:model.live.debounce.500ms="simulations.{{ $index }}.loanAmount" placeholder="Montante do empréstimo em euros...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-euro"></i></span>
                                </div>
                            </div>
                            @error("simulations.$index.loanAmount") <span class="text-danger">{{ $message }}</span> @enderror
                        </td>
                    @endforeach
                </tr>
                <tr>
                     <th scope="row" class="text-right" style="white-space: nowrap">Prazo componente fixa<span class="text-danger">*</span></th>
                    @foreach ($simulations as $index => $simulation)
                        <td colspan="5">
                            <input type="number" step="1" class="form-control simInput" id="inputNumberPaymentsFixedRate"
                                wire:model.live.debounce.500ms="simulations.{{ $index }}.numberPaymentsFixedRate"
                                placeholder="Período taxa fixa em meses...">
                            @error("simulations.$index.numberPaymentsFixedRate") <span class="text-danger">{{ $message }}</span> @enderror
                        </td>
                    @endforeach
                </tr>
                <tr> <th scope="row" class="text-right" style="white-space: nowrap">Taxa fixa<span class="text-danger">*</span></th>
                    @foreach ($simulations as $index => $simulation)
                        <td colspan="5">
                            <div class="input-group">
                                <input type="number" step="1" class="form-control simInput" id="inputAnnualInterestFixedRate"
                                    wire:model.live.debounce.500ms="simulations.{{ $index }}.annualInterestFixedRate"
                                    placeholder="Taxa fixa...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                </div>
                            </div>
                            @error("simulations.$index.annualInterestFixedRate") <span class="text-danger">{{ $message }}</span> @enderror
                        </td>
                    @endforeach
                </tr>
                <tr> <th scope="row" class="text-right" style="white-space: nowrap">Prazo componente variável<span class="text-danger">*</span></th>
                    @foreach ($simulations as $index => $simulation)
                        <td colspan="5">
                            <input type="number" step="1" class="form-control simInput" id="inputNumberPaymentsVariableRate"
                                wire:model.live.debounce.500ms="simulations.{{ $index }}.numberPaymentsVariableRate"
                                placeholder="Período taxa variável em meses...">
                            @error("simulations.$index.numberPaymentsVariableRate") <span class="text-danger">{{ $message }}</span> @enderror
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th scope="row" class="text-right" style="white-space: nowrap">
                        Spread contratado<span class="text-danger">*</span>
                        <br/>
                        <small>Euribor 12M:  <b>{{ $euribor }}%</b></small>
                    </th>
                    @foreach ($simulations as $index => $simulation)
                        <td colspan="5">
                            <div class="input-group">
                                <input type="number" step="1" class="form-control simInput" id="inputSpread"
                                    wire:model.live.debounce.500ms="simulations.{{ $index }}.spread"
                                    placeholder="Taxa fixa...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                </div>
                            </div>
                            @error("simulations.$index.spread") <span class="text-danger">{{ $message }}</span> @enderror
                        </td>
                    @endforeach
                </tr>


                @if(!empty($financialPlans))
                    <tr class="blank_row">
                        <td colspan="{{ count($simulations) * 5 + 1  }}">&nbsp;</td>
                    </tr>

                    <tr>
                        <th scope="col" class="text-right">ANO / PRESTAÇÃO</th>
                        @foreach ($simulations as $index => $simulation)
                            @isset($financialPlans[$index])
                                <th scope="col" class="text-right">PRESTAÇÃO MENSAL</th>
                                <th scope="col" class="text-right">AMORTIZAÇÃO DE CAPITAL</th>
                                <th scope="col" class="text-right">JUROS</th>
                                <th scope="col" class="text-right">CAPITAL EM DÍVIDA</th>
                                <th scope="col" class="text-right">TAN</th>
                            @else
                                <th colspan="5"/>
                            @endisset
                        @endforeach
                    </tr>

                    @for ($i = 0; $i<$maxPayments; $i++)
                        @include('financial-plan-row', ['simulations'=>$simulations, 'financialPlans' => $financialPlans, 'i' => $i, 'maxPayments' => $maxPayments ])
                    @endfor
                @endif




            </table>


        </div>
    </div>

</div>
