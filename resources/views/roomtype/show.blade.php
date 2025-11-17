@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{$data->title}}
                                <a href="{{url('admin/roomtype')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
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
                                        <th>{{ __('hotel-manager.price') }}</th>
                                        <td>{{$data->price}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.detail') }}</th>
                                        <td>{{$data->detail}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('hotel-manager.gallery_images') }}</th>
                                        <td>
                                            <table class="table table-bordered mt-3">
                                                <tr>
                                                    @foreach($data->roomtypeimgs as $img)
                                                    <td class="imgcol{{$img->id}}">
                                                        <img width="150" src="{{asset('storage/'.$img->img_src)}}" />
                                                    </td>
                                                    @endforeach
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
