<div>

        <button type="button"
            wire:click="toggleGraphShowTable()" title="{{__('mpa.mid_term_alt')}}"
            class="btn btn-light mr-4 {{ $graphShowTable==1 ? 'active' : '' }}" style="border-color: #ddd">
            <i class="fas fa-table-list"></i> {{ $graphShowTable ? __('mpa.tables_hide') : __('mpa.tables_show') }}
        </button>

        <span class="mr-2">{{ __('mpa.graphs_term') }}:</span>
        <div class="btn-group mr-4">
            <button type="button" wire:click="$set('graphTermMode', 0)" title="{{__('mpa.short_term_alt')}}"
                class="btn btn-light {{ (!isset($graphTermMode) || $graphTermMode == 0) ? 'active' : '' }}" style="border-color: #ddd">
                {{ __('mpa.short') }}
            </button>

            <button type="button" wire:click="$set('graphTermMode', 1)" title="{{__('mpa.mid_term_alt')}}"
                class="btn btn-light {{ $graphTermMode == 1 ? 'active' : '' }}" style="border-color: #ddd">
                {{ __('mpa.mid') }}
            </button>

            <button type="button" wire:click="$set('graphTermMode', 2)" title="{{__('mpa.long_term_alt')}}"
                class="btn btn-light {{ $graphTermMode == 2 ? 'active' : '' }}" style="border-color: #ddd">
                {{ __('mpa.long') }}
            </button>
        </div>


        <span class="mr-2">{{ __('mpa.graphs_type') }}:</span>
        <div class="btn-group">
            <button type="button" wire:click="$set('graphType', 2)" title="{{ __('mpa.graph_type_line_accumulated_alt') }}"
                class="btn btn-light {{ $graphType == 2 ? 'active' : '' }}" style="border-color: #ddd">
                <i class="fas fa-signal"></i>
            </button>

            <button type="button" wire:click="$set('graphType', 1)" title="{{ __('mpa.graph_type_line_alt') }}"
                class="btn btn-light {{ $graphType == 1 ? 'active' : '' }}" style="border-color: #ddd">
                <i class="fas fa-chart-line"></i>
            </button>

            <button type="button" wire:click="$set('graphType', 0)" title="{{ __('mpa.graph_type_stack_alt') }}"
                class="btn btn-light {{ (!isset($graphType) || $graphType == 0) ? 'active' : '' }}" style="border-color: #ddd">
                <i class="fas fa-chart-simple"></i>
            </button>
        </div>
    </div>
