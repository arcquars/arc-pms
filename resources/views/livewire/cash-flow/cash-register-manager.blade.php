<div>
    {{-- Manejo de alertas de Bootstrap --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- 
      Renderizado condicional:
      Si HAY sesión activa -> Mostrar formulario de CIERRE.
      Si NO HAY sesión activa -> Mostrar formulario de APERTURA.
    --}}
    
    @if ($activeSession)
        {{-- FORMULARIO DE CIERRE DE CAJA --}}
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-lock"></i>
                    Cerrar Caja (Sesión Abierta por: {{ $activeSession->user->name }})
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex bd-highlight">
                    <p class="card-text flex-fill bd-highlight">
                        Caja abierta a las: <strong>{{ $activeSession->opened_at->format('d/m/Y h:i A') }}</strong>
                    </p>
                    <div class="flex-fill bd-highlight text-right">
                        <button class="btn btn-sm btn-info" disabled>Ver reporte</button>
                    </div>
                </div>
                
                <div class="d-flex bd-highlight">
                    <p class="card-text flex-fill bd-highlight">
                        Fondo inicial (Apertura): <strong>Bs/ {{ number_format($activeSession->initial_cash, 2) }}</strong>
                    </p>
                    <p class="card-text flex-fill bd-highlight">
                        Total Ingresos: <strong>Bs/ {{ number_format($this->totalIncomes, 2) }}</strong>
                    </p>
                    <p class="card-text flex-fill bd-highlight">
                        Total Egresos: <strong>Bs/ {{ number_format($this->totalExpenses, 2) }}</strong>
                        
                    </p>
                </div>
                
                
                <p class="card-text text-info">
                    Total Sistema: <strong>Bs/ {{ number_format($this->calculatedCash, 2) }}</strong>
                </p>
                <hr>
                
                <form wire:submit.prevent="closeRegister">
                    {{-- Monto contado físicamente --}}
                    <div class="form-group">
                        <label for="counted_cash">Monto Contado Físicamente (Efectivo)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bs/</span>
                            </div>
                            <input type="number" step="0.01" class="form-control @error('counted_cash_at_close') is-invalid @enderror"
                                   id="counted_cash" wire:model.defer="counted_cash_at_close">
                        </div>
                        @error('counted_cash_at_close') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Notas de cierre --}}
                    <div class="form-group">
                        <label for="closing_notes">Notas de Cierre (Opcional)</label>
                        <textarea class="form-control" id="closing_notes" rows="3"
                                  wire:model.defer="closing_notes"
                                  placeholder="Ej: Faltante justificado, billete falso, etc."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-calculator"></i>
                            Calcular Cierre y Cerrar Caja
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                            Calculando...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    @else
        {{-- FORMULARIO DE APERTURA DE CAJA --}}
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-lock-open"></i>
                    Abrir Caja
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">No tienes una sesión de caja activa. Debes abrir una para registrar movimientos.</p>
                
                <form wire:submit.prevent="openRegister">
                    <div class="form-group">
                        <label for="initial_cash">Fondo Inicial (Efectivo)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bs/</span>
                            </div>
                            <input type="number" step="0.01" class="form-control @error('initial_cash') is-invalid @enderror"
                                   id="initial_cash" wire:model.defer="initial_cash">
                        </div>
                        @error('initial_cash') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-block" wire:loading.attr="disabled">
                        <i class="fas fa-play-circle"></i>
                        Iniciar Sesión de Caja
                    </button>
                </form>
            </div>
        </div>
    @endif


    {{-- 
      MODAL DE RESUMEN DE CIERRE (Bootstrap 4.6)
      Se activa con el evento 'show-closing-summary-modal'
    --}}
    <div 
        class="modal fade" 
        id="summaryModal" 
        tabindex="-1" 
        role="dialog" 
        aria-labelledby="summaryModalLabel" 
        aria-hidden="true"
        wire:ignore.self {{-- Importante para que Livewire no destruya el modal --}}
    >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="summaryModalLabel">Resumen de Cierre de Caja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Fondo Inicial (Apertura)</td>
                                <td class="text-right">Bs/ {{ number_format($activeSession->initial_cash ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Total Ingresos (+)</td>
                                <td class="text-right text-success">Bs/ {{ number_format($totalIncomes, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Total Egresos (-)</td>
                                <td class="text-right text-danger">Bs/ {{ number_format($totalExpenses, 2) }}</td>
                            </tr>
                            <tr class="table-info">
                                <td><strong>Monto Calculado por Sistema</strong></td>
                                <td class="text-right"><strong>Bs/ {{ number_format($calculatedCash, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Monto Contado Físicamente</td>
                                <td class="text-right">Bs/ {{ number_format($counted_cash_at_close ?? 0, 2) }}</td>
                            </tr>
                            <tr class="{{ $difference == 0 ? 'table-success' : ($difference > 0 ? 'table-warning' : 'table-danger') }}">
                                <td><strong>Diferencia (Sobrante / Faltante)</strong></td>
                                <td class="text-right">
                                    <strong>Bs/ {{ number_format($difference, 2) }}</strong>
                                    @if($difference > 0)
                                        <span class="badge badge-warning ml-2">SOBRANTE</span>
                                    @elseif($difference < 0)
                                        <span class="badge badge-danger ml-2">FALTANTE</span>
                                    @else
                                        <span class="badge badge-success ml-2">CUADRADO</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    @if($closing_notes)
                        <h6>Notas de Cierre:</h6>
                        <p class="text-muted">{{ $closing_notes }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    {{-- Aquí podrías añadir un botón para imprimir el reporte --}}
                </div>
            </div>
        </div>
    </div>
    
    {{-- Script para escuchar el evento de Livewire y mostrar el modal --}}
    <script>
        document.addEventListener('livewire:load', function () {
            window.addEventListener('show-closing-summary-modal', event => {
                $('#summaryModal').modal('show');
            });
        });
    </script>
</div>