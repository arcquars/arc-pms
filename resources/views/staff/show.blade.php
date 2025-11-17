@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.detail') }}: {{$data->full_name}}
                                <a href="{{url('admin/staff')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
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
                                        <th>{{ __('hotel-manager.department') }}</th>
                                        <td>{{$data->department->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.photo') }}</th>
                                        <td><img width="80" src="{{asset('storage/app/'.$data->photo)}}" /></td>
                                    </tr>
                                    <tr>
                                        <th>Bio</th>
                                        <td>{{$data->bio}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.salary_type') }}</th>
                                        <td>{{$data->salary_type}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.salary_amount') }}</th>
                                        <td>{{$data->salary_amt}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
