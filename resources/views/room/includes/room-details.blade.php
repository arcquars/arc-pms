<h5 style="color:#000">Habitación</h5>
<hr class="m-1">
<div class="row">
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Nombre</p>
        <p class="ml-2 mb-1">{{$room->title}}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Nivel</p>
        <p class="ml-2 mb-1">{{$room->roomLevel->name}}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Tipo</p>
        <p class="ml-2 mb-1">{{$room->roomType->title}}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Precio</p>
        <p class="ml-2 mb-1">{{$room->roomType->price}} {{ config('bookings.money') }}</p>
    </div>
</div>
@if($booking)
<div class="row">
    <div class="col-md-6">
        <h5 style="color: #000;">Huésped <a href="#" class="badge badge-pill badge-primary" title="Historial del huésped"><i class="fas fa-info"></i></a></h5>
    </div>
    <div class="col-md-6 text-right">
        <button class="btn btn-sm btn-primary">Enviar Formulario de satisfacción</button>
    </div>
</div>
<hr class="m-1">
<div class="row">
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Cliente</p>
        <p class="ml-2 mb-1">{{ $booking->customer? $booking->customer->full_name : "" }}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">NIT</p>
        <p class="ml-2 mb-1">{{ $booking->customer? $booking->customer->nit : "" }}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Correo</p>
        <p class="ml-2 mb-1">{{ $booking->customer? $booking->customer->email : "" }}</p>
    </div>
    <div class="col-md-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="c-send_email" value="1" name="booking[send_email]" @if($booking->send_email) checked @endif disabled>
            <label class="form-check-label" for="c-send_email">Enviar estado de cuenta por correo</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Fecha Ingreso</p>
        <p class="ml-2 mb-1">{{$booking->checkin_date}}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Fecha Salida</p>
        <p class="ml-2 mb-1">{{$booking->checkout_date}}</p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Tiempo restante hospedaje</p>
        <p class="ml-2 mb-1">{!! $booking->remainingHostingTime() !!} </p>
    </div>
    <div class="col-md-3">
        <p class="text-primary font-weight-bold mb-1">Estado</p>
        <div class="border rounded" style="background-color: {{ config('bookings.booking_status_colors.'.$booking->bookingLastStatus()->name) }};">
            <p class="text-white m-0 text-center">{{ __('hotel-manager.'.$booking->bookingLastStatus()->name ) }}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p class="text-primary font-weight-bold mb-1">Comentario</p>
        <p class="ml-2 mb-1">{{$booking->comments}}</p>
    </div>
    <div class="col-md-2">
        <p class="m-0"><a href="#" onclick="openViewAdultsModal({{ $booking->id }}); return false;"><i class="far fa-eye"></i></a> Adultos: <b>{{ $booking->total_adults }}</b></p>
        <p class="m-0">@if($booking->total_children > 0)<a href="#" class=""><i class="far fa-eye"></i></a>@endif Niños: <b>{{ $booking->total_children }}</b></p>
    </div>
    <div class="col-md-2">
        <p class="text-primary font-weight-bold mb-1">Descuento</p>
        @if($booking->discount_type == 1)
            <p class="ml-2 mb-1">{{$booking->discount}} %</p>
        @else
            <p class="ml-2 mb-1">{{$booking->discount}} {{ config('bookings.money') }}</p>
        @endif
    </div>
    <div class="col-md-2">
        <p class="text-primary font-weight-bold mb-1">Costo</p>
        <p class="ml-2 mb-1"><b>{{$booking->cost}} {{ config('bookings.money') }}</b></p>
    </div>
</div>
@endif
