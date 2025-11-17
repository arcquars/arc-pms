<div>
    <h5 class="text-primary">Historial de reservas</h5>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form wire:submit.prevent="search">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="f-dateStart">Fecha inicio</label>
                <input type="date" id="f-dateStart" wire:model.defer="dateStart" class="form-control form-control-sm @error('dateStart') is-invalid @enderror">
                @error('dateStart') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="f-dateEnd">Fecha fin</label>
                <input type="date" id="f-dateEnd" wire:model.defer="dateEnd" class="form-control form-control-sm @error('dateEnd') is-invalid @enderror">
                @error('dateEnd') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="f-textSearch">Cliente (Apellido o CI)</label>
                <input type="text" id="f-textSearch" wire:model.defer="textSearch" class="form-control form-control-sm @error('textSearch') is-invalid @enderror">
                @error('textSearch') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-3 d-flex ">
                <button type="submit" class="btn btn-sm btn-primary mt-auto mr-1">Buscar</button>
                <button type="button" class="btn btn-sm btn-secondary mt-auto" wire:click="resetFilters">Limpiar Filtros</button>
            </div>
        </div>
    </form>

    @if(isset($bookings) && count($bookings) > 0)
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>#</td>
                <td>Cliente</td>
                <td>Ultimo Estado</td>
                <td>Fecha checkIn</td>
                <td>Fecha checkOut</td>
                <td>Fecha reserva</td>
                <td>Acción</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($bookings as $index => $booking)
                <tr>
                    <td>{{ $bookings->firstItem() + $index }}</td>
                    <td>{{ $booking->customer->full_name_nit_name }}</td>
                    <td>{{ ($booking->bookingLastStatus())? __('hotel-manager.'.$booking->bookingLastStatus()->name) : '-' }}</td>
                    <td>{{ $booking->checkin_date }}</td>
                    <td>{{ $booking->checkout_date }}</td>
                    <td>{{ ($booking->bookingFirstStatus())? $booking->bookingFirstStatus()->created_at->format('Y-m-d') : '-' }}</td>
                    <td></td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    @else
        <div><p class="text-warning">Sin datos de reservas</p></div>
    @endif
</div>
