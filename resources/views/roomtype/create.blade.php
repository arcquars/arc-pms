@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.add_room_type') }}
                                <a href="{{url('admin/roomtype')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">

                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <p class="text-danger">{{$error}}</p>
                                @endforeach
                            @endif

                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                            <div class="table-responsive">
                                <form enctype="multipart/form-data" method="post" action="{{url('admin/roomtype')}}">
                                    @csrf
                                    <table class="table table-bordered" >
                                        <tr>
                                            <th>{{ __('hotel-manager.title') }}</th>
                                            <td><input name="title" type="text" class="form-control" /></td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('hotel-manager.price') }}</th>
                                            <td><input name="price" type="number" class="form-control" /></td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('hotel-manager.detail') }}</th>
                                            <td><textarea name="detail" class="form-control"></textarea></td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('hotel-manager.gallery') }}</th>
                                            <td><input type="file" multiple name="imgs[]" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" class="btn btn-primary" value="{{ __('hotel-manager.create') }}" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
