@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.add_room') }}
                                <a href="{{url('admin/rooms')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.back') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                            <div class="">
                                <form method="post" action="{{url('admin/rooms')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="rt_id" class="col-sm-2 col-form-label">{{ __('hotel-manager.select_room_type') }}</label>
                                        <div class="col-sm-10">
                                            <select id="rt_id" name="rt_id" class="form-control @error('rt_id') is-invalid @enderror">
                                                <option value="">--- {{ __('hotel-manager.select_room_type') }} ---</option>
                                                @foreach($roomtypes as $rt)
                                                    <option value="{{$rt->id}}" {{ ($rt->id == old('rt_id'))?'selected':'' }}>{{$rt->title}}</option>
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
                                                    <option value="{{$rLevel->id}}" {{ ($rLevel->id == old('rlevel_id'))?'selected':'' }}>{{$rLevel->name}}</option>
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
                                                   value="{{@old('title')}}" />
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <input type="submit" class="btn btn-sm btn-primary" value="{{ __('hotel-manager.create') }}" />
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@endsection
