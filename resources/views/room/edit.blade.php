@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.edit_room') }}
                                <a href="{{url('admin/rooms')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                                <form method="post" action="{{url('admin/rooms/'.$data->id)}}">
                                @csrf
                                @method('put')
                                    <div class="form-group row">
                                        <label for="rt_id" class="col-sm-2 col-form-label">{{ __('hotel-manager.select_room_type') }}</label>
                                        <div class="col-sm-10">
                                            <select id="rt_id" name="rt_id" class="form-control @error('rt_id') is-invalid @enderror">
                                                <option value="">--- {{ __('hotel-manager.select_room_type') }} ---</option>
                                                @foreach($roomtypes as $rt)
                                                    <option value="{{$rt->id}}" @if($data->room_type_id==$rt->id) selected @endif {{ old('rt_id') === $rt->id ? 'selected' : '' }}>{{$rt->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('rt_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rlevel_id" class="col-sm-2 col-form-label">{{ __('hotel-manager.room_levels') }}</label>
                                        <div class="col-sm-10">
                                            <select id="rlevel_id" name="rlevel_id" class="form-control @error('rlevel_id') is-invalid @enderror">
                                                <option value="">--- {{ __('hotel-manager.room_level') }} ---</option>
                                                @foreach($roomLevels as $rLevel)
                                                    <option value="{{$rLevel->id}}" @if($data->room_level_id==$rLevel->id) selected @endif {{ old('rlevel_id') === $rLevel->id ? 'selected' : '' }}>{{$rLevel->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('rlevel_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="title_id" class="col-sm-2 col-form-label">{{ __('hotel-manager.title') }}</label>
                                        <div class="col-sm-10">
                                            <input id="title_id" name="title" type="text" class="form-control @error('title') is-invalid @enderror" autocomplete="off"
                                                   value="{{@old('title', $data->title)}}" />
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="{{ __('hotel-manager.save') }}" />
                                </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
