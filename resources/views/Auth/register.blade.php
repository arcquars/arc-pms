@extends('layout.auth')
@section('content')
    <div class="row justify-content-center" style="margin-top: 60px">
        <div class="col-md-4 col-md-offset-4">
            <h4>Create New Account</h4>
            <form action="{{route('Auth.store')}}" method="POST">
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-success">
                        {{Session::get('fail')}}
                    </div>
                @endif

                @csrf
                <div class="form-group">
                    <label>Name:</label>
                    <input type="name" name="name" class="form-control" placeholder="Enter your full name hear.." value="{{old('name')}}">
                    <span class="text-danger">@error('name')
                        {{$message}}
                        @enderror</span>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email hear.." value="{{old('email')}}">
                    <span class="text-danger">@error('email')
                        {{$message}}
                        @enderror</span>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password hear.." >
                    <span class="text-danger">@error('password')
                        {{$message}}
                        @enderror</span>
                </div>
                <button class="btn btn-block btn-primary">Create Account</button>
                <span>I have an account <a href="{{ route('Auth.login')}}">login hear</a></span>
            </form>
        </div>
    </div>
@endsection
