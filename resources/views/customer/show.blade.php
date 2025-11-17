@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{$data->full_name}}
                                <a href="{{url('admin/customer')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" >
                                    <tr>
                                        <th>{{ __('hotel-manager.full_name') }}</th>
                                        <td>{{$data->full_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.photo') }}</th>
                                        <td><img width="100" src="{{asset('storage/app/'.$data->photo)}}" /></td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.email') }}</th>
                                        <td>{{$data->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.mobile') }}</th>
                                        <td>{{$data->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.address') }}</th>
                                        <td>{{$data->address}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
