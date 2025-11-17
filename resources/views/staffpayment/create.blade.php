@extends('layout')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.add_staff_payment') }}
                                <a href="{{url('admin/staff/payments', ['id' => $staff->id])}}" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                            <div class="table-responsive">
                                <form method="post" action="{{url('admin/staff/payment/'.$staff->id)}}">
                                    @csrf
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>{{ __('hotel-manager.amount') }}</th>
                                            <td><input name="amount" type="text" class="form-control" /></td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('hotel-manager.date') }}</th>
                                            <td><input name="amount_date" class="form-control" type="date" /></td>
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
