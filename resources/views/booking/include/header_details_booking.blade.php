<fieldset class="border p-1">
    <legend class="w-auto h6 text-primary font-weight-bold">Datos de la habitacion</legend>
    <div class="row">
        <div class="col-md-4">
            <p class="font-weight-bold m-0">Nombre</p>
            <p class="text-primary m-0 pl-2">{{ $booking->room->title }}</p>
        </div>
        <div class="col-md-4">
            <p class="font-weight-bold m-0">Tipo</p>
            <p class="text-primary m-0 pl-2"><small>{{ $booking->room->roomType->title }}</small></p>
        </div>
        <div class="col-md-4">
            <p class="font-weight-bold m-0">Costo</p>
            <p class="text-primary m-0 pl-2">{{ $booking->room->roomType->price }} {{ config('bookings.money') }}</p>
        </div>
    </div>
</fieldset>
<fieldset class="border p-1">
    <legend class="w-auto h6 text-primary font-weight-bold">Datos del cliente</legend>
    <div class="row">
        <div class="col-md-4">
            <p class="font-weight-bold m-0">Nombre</p>
            <p class="text-primary m-0 pl-2"><small>{{ $booking->customer->full_name }}</small></p>
        </div>
        <div class="col-md-4">
            <p class="font-weight-bold m-0">NIT</p>
            <p class="text-primary m-0 pl-2"><small>{{ $booking->customer->nit }}</small></p>
        </div>
        <div class="col-md-4">
            <p class="font-weight-bold m-0">Fecha entrada</p>
            <p class="text-primary m-0 pl-2"><small>{{ $booking->checkin_date }}</small></p>
        </div>
    </div>
</fieldset>
