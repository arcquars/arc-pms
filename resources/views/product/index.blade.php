@extends('layout')
@section('content')

    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Productos
                    <a href="{{url('admin/product/create')}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.add_new') }}</a>
                </h6>
            </div>
            <div class="card-body">
                @livewire('product-component')
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection

