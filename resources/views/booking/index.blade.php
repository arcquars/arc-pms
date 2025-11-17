@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reservas
                                <a href="{{url('admin/booking/calendar')}}" class="float-right btn btn-success btn-sm ml-2">{{ __('hotel-manager.calendar') }}</a>
{{--                                <a href="{{url('admin/booking/create')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.add_new') }}</a>--}}
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif

                                <form class="form-inline" action="" method="GET">
                                    @csrf
                                    <label class="sr-only" for="b-search-room">Habitacion</label>
{{--                                    <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Habitacion">--}}
                                    <select name="room" id="b-search-room" class="form-control mb-2 mr-sm-2">
                                        <option value="">Habitacion</option>
                                        @foreach($roomsForSelect as $id => $title)
                                            <option value="{{$id}}" @if($roomSelect == $id) selected @endif>{{$title}}</option>
                                        @endforeach
                                    </select>

                                    <label class="sr-only" for="b-search-date">Fecha</label>
                                    <div class="form-check mb-2 mr-sm-2">
                                        <input type="date" class="form-control" id="b-search-date" name="date" value="{{ $dateSelect }}" >
                                    </div>

                                    <label class="sr-only" for="b-search-customer">Cliente</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">@</div>
                                        </div>
                                        <input type="text" class="form-control" id="b-search-customer" placeholder="Cliente" name="customer" value="{{$customerSelect}}">
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button>
                                    <a href="{{url('admin/booking')}}" class="btn btn-primary mb-2 ml-2"><i class="fas fa-eraser"></i></a>
                                </form>
                            @if ($data->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('hotel-manager.customer') }}</th>
                                            <th>{{ __('hotel-manager.room_no') }}</th>
                                            <th>Estado</th>
                                            <th>{{ __('hotel-manager.checkin_date') }}</th>
                                            <th>{{ __('hotel-manager.checkout_date') }}</th>
                                            <th>Fecha de Reserva</th>
                                            <th>Usuario que Reservo</th>
                                            <th>{{ __('hotel-manager.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('hotel-manager.customer') }}</th>
                                            <th>{{ __('hotel-manager.room_no') }}</th>
                                            <th>Estado</th>
                                            <th>{{ __('hotel-manager.checkin_date') }}</th>
                                            <th>{{ __('hotel-manager.checkout_date') }}</th>
                                            <th>Fecha de Reserva</th>
                                            <th>Usuario que Reservo</th>
                                            <th>{{ __('hotel-manager.action') }}</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($data as $booking)
                                        <tr>
                                            <td>{{$booking->id}}</td>
                                            <td>{{$booking->customer? $booking->customer->full_name : ""}}</td>
                                            <td>{{$booking->room->title}}</td>
                                            <td>{{ __('hotel-manager.'.$booking->last_status->name) }}</td>
                                            <td>{{$booking->checkin_date}}</td>
                                            <td>{{$booking->checkout_date}}</td>
                                            <td>{{ $booking->getBookingStatusReservation()->created_at }}</td>
                                            <td>{{ ($booking->getBookingStatusReservation()->user)? $booking->getBookingStatusReservation()->user->name : '-' }}</td>

                                            <td>
                                                <a class="btn btn-sm btn-link text-primary" href="{{ route('admin.booking.statusBooking', ['bookingId' => $booking->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{url('admin/booking/'.$booking->id.'/delete')}}" class="btn btn-sm btn-link text-danger" onclick="return confirm('Are you sure you want to delete this data?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $data->links() }}
                            </div>
                            @else
                                <p>No hay posts disponibles.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

@section('scripts')

@endsection

@endsection
