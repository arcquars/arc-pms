@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.show_room') }}
                                <a href="{{url('admin/rooms')}}" class="float-right btn btn-success btn-sm ml-1">{{ __('hotel-manager.view_all') }}</a>
                                <a href="{{url('admin/rooms/' . $data->id . '/edit')}}" class="float-right btn btn-primary btn-sm ml-1">{{ __('hotel-manager.edit_room') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" >
                                    <tr>
                                        <th>{{ __('hotel-manager.title') }}</th>
                                        <td>{{$data->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.room_type') }}</th>
                                        <td>{{$data->Roomtype->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.room_level') }}</th>
                                        <td>{{$data->RoomLevel->name}}</td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <livewire:room-history-bookings :roomId="$data->id"></livewire:room-history-bookings>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
