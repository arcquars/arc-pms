<div>
    {{--
        Estructura del Modal de Bootstrap 4.6
        Se usa la directiva @if para renderizar condicionalmente,
        y así aprovechar la optimización de Livewire.
    --}}
    @if ($showModal)
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Abrir Caja</h5>
                        <button type="button" class="close" aria-label="Close" wire:click="$emit('close-modal')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mBalInit">Balance inicial <span class="text-danger">*</span></label>
                            <input 
                                wire:model.defer="initialBalance" 
                                id="mBalInit" 
                                type="number" step="0.1" 
                                class="form-control @error('initialBalance')
                                    is-invalid
                                @enderror"
                                placeholder="Ej: 0.0"
                            >
                            @error('initialBalance')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$emit('close-modal')">
                            Cerrar
                        </button>
                        <button type="button" wire:click="saveCashFlow" class="btn btn-primary">
                            Registrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" wire:click="$emit('close-modal')"></div>
    @endif
</div>