@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.add_room_level') }}
                                <a href="{{url('admin/roomlevel')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">

                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                                <form enctype="multipart/form-data" method="post" action="{{url('admin/roomlevel')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="frl-name" class="col-sm-2 col-form-label">{{ __('hotel-manager.room_level_name') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="frl-name"
                                                   value="{{@old('name')}}" />
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="frl-detail" class="col-sm-2 col-form-label">{{ __('hotel-manager.detail') }}</label>
                                        <div class="col-sm-10">
                                            <textarea id="frl-detail" name="detail" class="form-control @error('detail') is-invalid @enderror">{{@old('detail')}}</textarea>
                                            @error('detail')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="{{ __('hotel-manager.create') }}" />
                                </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
