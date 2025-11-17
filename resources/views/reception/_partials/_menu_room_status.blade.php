<?php
$isBlocked = true;
?>
<div>
    <nav class="nav flex-column">
        @if($room->roomStatus && $room->roomStatus->active)
            @switch($room->roomStatus->name)
                @case(\App\Models\RoomStatus::STATUS_CLEANING)
                    <a class="nav-link text-danger" href="#" onclick="openRoomStatusCloseModal({{$room->roomStatus->id}}); return false;" ><i class="{{ config("bookings.state_icons")[\App\Models\RoomStatus::STATUS_CLEANING] }}"></i> Cerrar Limpieza</a>
                    @break;
                @case(\App\Models\RoomStatus::STATUS_MAINTENANCE)
                    @php $isBlocked = false; @endphp
                    <a class="nav-link text-danger" href="#" onclick="openRoomStatusCloseModal({{$room->roomStatus->id}}); return false;" ><i class="{{ config("bookings.state_icons")[\App\Models\RoomStatus::STATUS_MAINTENANCE] }}"></i> Cerrar Mantenimiento</a>
                    @break;
                @case(\App\Models\RoomStatus::STATUS_BLOOKED)
                @php $isBlocked = false; @endphp
                    <a class="nav-link text-danger" href="#" onclick="openRoomStatusCloseModal({{$room->roomStatus->id}}); return false;" ><i class="{{ config("bookings.state_icons")[\App\Models\RoomStatus::STATUS_BLOOKED] }}"></i> Cerrar Bloqueo</a>
                    @break;
            @endswitch
        @else
            <a class="nav-link" href="#" onclick="openRoomStatusCreateModal({{$room->id}}, @if($booking) {{$booking->id}} @else 0 @endif, '{{\App\Models\RoomStatus::STATUS_CLEANING}}'); return false;" ><i class="{{ config("bookings.state_icons")[\App\Models\RoomStatus::STATUS_CLEANING] }}"></i> {{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_CLEANING) }}</a>
            @if(!$booking)
            <a class="nav-link" href="#" onclick="openRoomStatusCreateModal({{$room->id}}, @if($booking) {{$booking->id}} @else 0 @endif, '{{\App\Models\RoomStatus::STATUS_MAINTENANCE}}'); return false;"><i class="{{ config("bookings.state_icons")[\App\Models\RoomStatus::STATUS_MAINTENANCE] }}"></i> {{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_MAINTENANCE) }}</a>
            <a class="nav-link" href="#" onclick="openRoomStatusCreateModal({{$room->id}}, @if($booking) {{$booking->id}} @else 0 @endif, '{{\App\Models\RoomStatus::STATUS_BLOOKED}}'); return false;"><i class="{{ config("bookings.state_icons")[\App\Models\RoomStatus::STATUS_BLOOKED] }}"></i> {{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_BLOOKED) }}</a>
            @endif
        @endif

        @if($booking)
            @if($isBlocked)
                <hr class="p-0 m-0 bg-primary">
{{--                @if($booking->bookingLastStatus() && strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_INCOME) != 0)--}}
{{--                <a class="nav-link" onclick="openCreateBookingStatusModal({{$booking->id}}, '{{\App\Models\BookingStatus::STATUS_INCOME}}'); return false;" href="#">--}}
{{--                    <i class="fas fa-sign-in-alt"></i> Registrar Ingreso--}}
{{--                </a>--}}
{{--                @endif--}}

                @if($booking->bookingLastStatus() && strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED) == 0
                    || $booking->bookingLastStatus() && strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_RESERVATION_CONFIRMED) == 0)
                    <a class="nav-link" onclick="openCreateBookingStatusModal({{$booking->id}}, '{{\App\Models\BookingStatus::STATUS_INCOME}}'); return false;" href="#">
                        <i class="fas fa-sign-in-alt"></i> Registrar Ingreso
                    </a>
                @endif

                @if($booking->bookingLastStatus() && strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_RESERVATION_CONFIRMED) == 0 || $booking->bookingLastStatus() && strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED) == 0)
                    <a class="nav-link text-danger" onclick="openCreateBookingStatusModal({{$booking->id}}, '{{\App\Models\BookingStatus::STATUS_NO_INCOME}}'); return false;" href="#">
                        <i class="fas fa-ban"></i> No ingreso
                    </a>
                @endif

                @if($booking->bookingLastStatus() && strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_INCOME) == 0)
                <a class="nav-link" onclick="openSellingProductsModal({{$booking->id}}); return false;" href="#">
                    <i class="fas fa-store"></i> Vender
                </a>
                <a class="nav-link" onclick="openCreateBookingStatusModal({{$booking->id}}, '{{\App\Models\BookingStatus::STATUS_HOSTING_COMPLETED}}'); return false;" href="#">
                    <i class="fas fa-sign-out-alt"></i> Registrar Salida
                </a>

                @endif
                <a class="nav-link" href="{{ route('admin.booking.statusBooking', ['bookingId' => $booking->id]) }}">
                    <i class="fas fa-eye"></i> Ver estado
                </a>
            @endif
        @else
            @if($isBlocked)
                <hr class="p-0 m-0 bg-primary">
{{--                admin.reception.process-room --}}
            <a class="nav-link" href="{{route('admin.reception.process-room', ['roomId' => $room->id])}}">
                <i class="fas fa-hotel"></i> Registrar Ingreso
            </a>
            @endif
        @endif
    </nav>
</div>
