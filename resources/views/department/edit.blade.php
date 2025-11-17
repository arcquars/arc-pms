@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.update_department') }}
                                <a href="{{url('admin/department')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                            <div class="table-responsive">
                                <form method="post" action="{{url('admin/department/'.$data->id)}}">
                                    @csrf
                                    @method('put')
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>{{ __('hotel-manager.title') }}</th>
                                            <td><input value="{{$data->title}}" name="title" type="text" class="form-control" /></td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('hotel-manager.detail') }}</th>
                                            <td>
                                                <textarea name="detail" class="form-control">{{$data->detail}}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" class="btn btn-primary" value="{{ __('hotel-manager.save') }}" />
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
