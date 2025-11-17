<div>
    {{-- Si $showModal es true, se renderiza el modal --}}
    @if ($showModal)
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg" role="document"> {{-- 'modal-lg' para más espacio --}}
                <div class="modal-content">
                    
                    {{-- Encabezado del Modal --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Gestión de Caja</h5>
                        {{-- Botón de cierre (X) que llama al método 'close' --}}
                        <button type="button" class="close" wire:click="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    {{-- Cuerpo del Modal --}}
                    <div class="modal-body">
                        {{-- 
                          ¡AQUÍ ESTÁ LA MAGIA! 
                          Cargamos el componente CashRegisterManager que ya creamos.
                          Livewire maneja esto como un componente hijo anidado.
                        --}}
                        @livewire('cash-flow.cash-register-manager')
                    </div>
                    
                    {{-- Pie de página del Modal --}}
                    <div class="modal-footer">
                        {{-- Botón para cerrar el modal --}}
                        <button type="button" class="btn btn-secondary" wire:click="close">
                            Cancelar
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- Backdrop/Overlay (al hacer clic fuera, se cierra) --}}
        <div class_alias="modal-backdrop fade show" wire:click="close"></div>
    @endif
</div>