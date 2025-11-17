@extends('layout')
@section('content')
    @include("customer.include.modals.m_create_customer")
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                Procesar Habitacion
            </div>
            <div class="card-body">

                <form method="POST" action="{{route('admin.reception.saveRoomBusy')}}">
                    @csrf
                    @include('room.includes.room-details', ['room' => $room, 'booking' => null])

                    <div class="card shadow mb-4 border-top-hotel">
                        <div class="card-body row">
                            <div class="col-md-6">
                                @include('reception._partials.customer-booking')
                            </div>
                            <div class="col-md-6">
                                @include('reception._partials.room-booking', ['roomType' => $room->roomType, 'room_id' => $room->id, 'startDate' => $startDate, 'endDate' => $endDate])
                                <div style="width: 100%;">
                                    <a href="{{url()->previous()}}" class="btn btn-sm btn-warning">Atras</a>
                                    <button type="submit" class="btn btn-sm btn-primary float-right">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
        });

    </script>
@endsection

