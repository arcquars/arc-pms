@extends('layout')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.rooms') }}
                        <a href="{{url('admin/rooms/create')}}" class="float-right btn btn-secondary btn-sm">{{ __('hotel-manager.add_new') }}</a>
                </h6>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <p class="text-success">{{session('success')}}</p>
                @endif
                    <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hotel-arc" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('hotel-manager.room_type')}}</th>
                                <th>{{__('hotel-manager.title')}}</th>
                                <th>{{__('hotel-manager.action')}}</th>
                            </tr>
                        </thead>
                        <tfoot class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>{{__('hotel-manager.room_type')}}</th>
                                <th>{{__('hotel-manager.title')}}</th>
                                <th>{{__('hotel-manager.action')}}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @if($data)
                                @foreach($data as $d)
                                <tr>
                                    <td>{{$d->id}}</td>
                                    <td>{{$d->roomtype->title}}</td>
                                    <td>{{$d->title}}</td>
                                    <td>
                                        <a href="{{url('admin/rooms/'.$d->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{url('admin/rooms/'.$d->id).'/edit'}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
{{--                                                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{url('admin/rooms/'.$d->id).'/delete'}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>--}}
                                        <a onclick="return confirm('Are you sure to delete this data?')" href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
                <!-- /.container-fluid -->

@section('scripts')
<!-- Custom styles for this page -->
<link href="{{asset('public')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Page level plugins -->
<script src="{{asset('public')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('public')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
{{--<script src="{{asset('public')}}/js/demo/datatables-demo.js"></script>--}}
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
                language: {!! json_encode(Lang::get('datatables')) !!}
            });
    });
</script>



@endsection

@endsection
