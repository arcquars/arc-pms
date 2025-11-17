<div>
    {{-- 
      Este componente gestiona el CRUD de transacciones varias (Ingresos/Egresos)
      y sus movimientos de caja asociados.
    --}}

    {{-- 1. Alertas de Feedback (Bootstrap 4.6) --}}
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

    {{-- 2. Encabezado y Botón de Creación --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Movimientos de caja (Caja Chica)</h6>
            <button class="btn btn-primary btn-sm" wire:click="create">
                <i class="fas fa-plus"></i> Nueva Transacción
            </button>
        </div>
        
        {{-- --- FILTROS DE BÚSQUEDA (NUEVOS) --- --}}
        <div class="card-body border-bottom">
            <div class="row">
                {{-- Filtro de Fecha de Inicio --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small mb-1">Fecha Desde</label>
                        <input type="date" class="form-control form-control-sm" wire:model="filterStartDate">
                    </div>
                </div>

                {{-- Filtro de Fecha de Fin --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small mb-1">Fecha Hasta</label>
                        <input type="date" class="form-control form-control-sm" wire:model="filterEndDate">
                    </div>
                </div>

                {{-- Filtro por Tipo (Ingreso/Egreso) --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small mb-1">Tipo</label>
                        <select class="form-control form-control-sm" wire:model="filterType">
                            <option value="">-- Todos --</option>
                            <option value="income">Ingresos (+)</option>
                            <option value="expense">Egresos (-)</option>
                        </select>
                    </div>
                </div>

                {{-- Filtro por Usuario (Toggle) --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="small mb-1 d-block">Usuario</label>
                        <div class="custom-control custom-checkbox pt-2">
                            <input type="checkbox" class="custom-control-input" id="filterByUser" wire:model="filterByUser">
                            <label class="custom-control-label" for="filterByUser">
                                Mostrar solo mis movimientos
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- --- FIN FILTROS DE BÚSQUEDA --- --}}
        
        {{-- 3. Tabla de Transacciones (Listado) --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $tx)
                            <tr>
                                <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $tx->category }}</td>
                                <td>{{ $tx->notes }}</td>
                                <td>
                                    @if ($tx->cashMovement->type == 'income')
                                        <span class="badge badge-success">Ingreso</span>
                                    @else
                                        <span class="badge badge-danger">Egreso</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- El monto siempre se guarda positivo o negativo, lo mostramos positivo --}}
                                    S/ {{ number_format(abs($tx->cashMovement->amount), 2) }}
                                </td>
                                <td>{{ $tx->cashMovement->payment_method }}</td>
                                <td>
                                    <button 
                                        class="btn btn-sm btn-warning" 
                                        @if(!$tx->canModifyOpenSession()) disabled title="La caja se cerro para este registro" @else title="Editar" @endif
                                        wire:click="edit({{ $tx->id }})"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button 
                                        class="btn btn-sm btn-danger" 
                                        @if(!$tx->canModifyOpenSession()) disabled title="La caja se cerro para este registro" @else title="Eliminar" @endif
                                        wire:click="confirmDelete({{ $tx->id }})"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay transacciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Paginación de Livewire (Bootstrap) --}}
            {{ $transactions->links() }}
        </div>
    </div>


    {{-- 4. Modal de Creación/Edición (Bootstrap 4.6) --}}
    @if ($showModal)
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{-- Título dinámico si estamos creando o editando --}}
                            {{ $transactionId ? 'Editar Transacción' : 'Nueva Transacción' }}
                        </h5>
                        <button type="button" class="close" wire:click="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    {{-- El formulario llama a wire:submit.prevent="save" --}}
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            
                            {{-- Error general (ej: "Caja cerrada") --}}
                            @error('general')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="row">
                                {{-- Columna 1: Detalles de Transacción --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Categoría <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm @error('state.category') is-invalid @enderror"
                                               wire:model.defer="state.category">
                                        @error('state.category') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Notas / Descripción <span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm @error('state.notes') is-invalid @enderror" rows="3"
                                                  wire:model.defer="state.notes"></textarea>
                                        @error('state.notes') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Ref. Factura (Opcional)</label>
                                        <input type="text" class="form-control form-control-sm @error('state.invoice_reference') is-invalid @enderror"
                                               wire:model.defer="state.invoice_reference">
                                        @error('state.invoice_reference') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                {{-- Columna 2: Detalles Monetarios --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de Movimiento</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="type_income"
                                                       value="income" wire:model="state.type">
                                                <label class="form-check-label text-success" for="type_income">Ingreso (+)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="type_expense"
                                                       value="expense" wire:model="state.type">
                                                <label class="form-check-label text-danger" for="type_expense">Egreso (-)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Monto <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs/</span>
                                            </div>
                                            <input type="number" step="0.01" class="form-control @error('state.amount') is-invalid @enderror"
                                                   wire:model.defer="state.amount">
                                            @error('state.amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Método de Pago <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm @error('state.payment_method') is-invalid @enderror"
                                                wire:model.defer="state.payment_method">
                                            @foreach ($paymentMethods as $method)
                                                <option value="{{ $method }}">{{ __('hotel-manager.'.$method) }}</option>
                                            @endforeach
                                        </select>
                                        @error('state.payment_method') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" wire:click="closeModal">Cancelar</button>
                            <button type="submit" class="btn btn-sm btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-save"></i> Guardar
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin"></i> Guardando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Backdrop/Overlay (al hacer clic fuera, se cierra) --}}
        <div class="modal-backdrop fade show" wire:click="closeModal"></div>
    @endif


    {{-- 5. Modal de Confirmación de Eliminación --}}
    @if ($showConfirmDeleteModal)
        <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h5>
                        <button type="button" class="close" wire:click="$set('showConfirmDeleteModal', false)" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de eliminar esta transacción? Esta acción es irreversible y eliminará también el movimiento de caja asociado.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showConfirmDeleteModal', false)">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="deleteTransaction" wire:loading.attr="disabled">
                            <span wire:loading.remove>Sí, Eliminar</span>
                            <span wire:loading>Eliminando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" wire:click="$set('showConfirmDeleteModal', false)"></div>
    @endif
</div>