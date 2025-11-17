@extends('layout')
@section('content')
    @include('booking.include.modals.m_list_huesped')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-1 mt-1 border-top-hotel">
            <div class="card-header py-3">
                Detalle del Hospedaje
            </div>
            <div class="card-body">
                @include('room.includes.room-details', ['room' => $booking->room, 'booking' => $booking])
                <form id="fTerminateStay" action="{{ route('admin.booking.terminate_stay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    @include('booking.partials._form_hosting_completed', ['booking' => $booking, 'formActive' => $formActive])

                    @if($booking->countExtraSalePaidExtra() > 0)
                    <div>
                        <h6 class="text-success"><i class="fas fa-file-invoice"></i> Recibos: </h6>
                        @foreach($booking->receipts as $index => $receipt)
                            @if(strcmp($receipt->payment_status, \App\Models\Receipt::PAYMENT_STATUS_PAID_EXTRA) == 0)
                                <a href="{{ route('admin.booking.invoice.extra', ['id' => $receipt->id]) }}" class="btn btn-sm btn-outline-secondary"
                                   target="_blank" title="Descargar Recibo"
                                >
                                    # {{$index+1}} | {{ $receipt->issue_date }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                    @endif
                    <div class="d-flex bd-highlight mb-3 pt-2">

                        <div class="mr-auto bd-highlight">
                            <a href="{{url()->previous()}}" class="btn btn-secondary btn-sm">Atras</a>
                            <button type="button" class="btn btn-cleaning btn-sm" @if(!$formActive) disabled @endif>
                                Realizar limpieza intermedia
                            </button>
                        </div>
                        <div class="bd-highlight">
                            @if(strcmp($booking->bookingLastStatus()->name, \App\Models\BookingStatus::STATUS_HOSTING_COMPLETED) == 0)
                            <a href="{{ route('admin.booking.invoice', ['id' => $booking->id]) }}" class="btn btn-primary btn-sm" >
                                Imprimir
                            </a>
                            @endif
                            <button type="submit" class="btn btn-success btn-sm" @if(!$formActive) disabled @endif>
                                Terminar estadia y limpiar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            recalculateTotal();
        });

        function openViewAdultsModal(bookingId){
            // alert(bookingId);
            openlistHuespedModal(bookingId);
        }
    </script>
@endsection


