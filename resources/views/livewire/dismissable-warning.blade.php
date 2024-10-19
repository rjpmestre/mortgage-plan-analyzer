<div>
    @if(!session($warningId))
        <div class="row">
            <div class="col">
                <div id="warning-card" class="card alert-warning mt-{{$mt}} mb-2 mx-2">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="remove" wire:click="dismiss">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        {{__('mpa.'.$warningId)}}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
