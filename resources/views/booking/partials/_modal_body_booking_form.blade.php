<?php
?>
@csrf
<input type="hidden" name="booking_id" value="{{$booking->id}}">
<input type="hidden" name="booking_status_next" value="{{ $nextBookingStatus }}">
<input type="hidden" name="booking_status_name" value="{{ $bookingStatus->name }}">
<h5 class="text-center mb-1" style="color: {{ $bookingStatus->color }};">{{ $room->title }}</h5>
<h6 class="text-center" style="color: {{ $bookingStatus->color }};">({{ __('hotel-manager.'.$bookingStatus->name) }})</h6>
<dl class="mb-0">
    <dt><p class="m-0"><small><b>Cliente</b></small></p></dt>
    <dd><p class="m-0">{{ $person->fullname }}</p></dd>
</dl>
<div class="row">
    <div class="col-md-6">
        <dl class="mb-1">
            <dt><p class="m-0"><small><b>Fecha Ingreso</b></small></p></dt>
            <dd><p class="m-0">{{ $booking->checkin_date }}</p></dd>
            <dt><p class="m-0"><small><b>Adultos</b></small></p></dt>
            <dd><p class="m-0">{{ $booking->total_adults }}</p></dd>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="mb-1">
            <dt><p class="m-0"><small><b>Fecha Salida</b></small></p></dt>
            <dd><p class="m-0">{{ $booking->checkout_date }}</p></dd>
            <dt><p class="m-0"><small><b>Niños</b></small></p></dt>
            <dd><p class="m-0">{{ $booking->total_children }}</p></dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <dl class="mb-1">
            <dt><p class="m-0"><small><b>Siguiente Estado</b></small></p></dt>
            <dd>
                <div class="border rounded" style="background-color: {{ config('bookings.booking_status_colors.'.$nextBookingStatus) }};">
                    <p class="text-white m-0 text-center">{{ __('hotel-manager.'.$nextBookingStatus) }}</p>
                </div>
            </dd>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="mb-1">
            <dt><p class="m-0"><small><b>Fecha registro</b></small></p></dt>
            <dd>
                <div class="border rounded" style="background-color: {{ config('bookings.booking_status_colors.'.$nextBookingStatus) }};">
                    <p class="text-white m-0 text-center"><small>{{ $now }}</small></p>
                </div>
            </dd>
        </dl>
    </div>
</div>
<hr class="m-1 bg-primary">
@switch($nextBookingStatus)
    @case(\App\Models\BookingStatus::STATUS_INCOME)
        @if(strcmp($bookingStatus->name, \App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED) == 0)
            @include('booking.partials._sub_form_not_confirmed', ['booking' => $booking])
        @else
            @include('booking.partials._sub_form_confirmed', ['booking' => $booking])
        @endif
        @break
    @case(\App\Models\BookingStatus::STATUS_NO_INCOME)
        @include('booking.partials._sub_form_not_income', ['booking' => $booking])
        @break
    @case(\App\Models\BookingStatus::STATUS_HOSTING_COMPLETED)
        <div class="modal-pdm">
            @include('booking.partials._sub_form_hosting_completed', ['booking' => $booking, 'formActive' => true])
        </div>
        @break
    @default
        default
        @break
@endswitch
