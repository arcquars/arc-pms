@extends('layout')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Consolidado por Dia: {{ $date }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="rcdDate">Fecha:</label>
                        <input type="date" id="rcdDate" name="date" class="form-control form-control-sm" value="{{$date}}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="#" class="btn btn-sm btn-primary" onclick="loadReport(); return false;">Buscar</a>
                    </div>
                </div>

                <hr>
                <ul>
                    <li>Total de reservas activas: <strong>{{ $totalReservations }}</strong></li>
{{--                    <li>Ingresos del día: <strong>${{ number_format($totalIncome, 2) }}</strong></li>--}}
                    <li>Check-ins: <strong>{{ $checkins }}</strong></li>
                    <li>Check-outs: <strong>{{ $checkouts }}</strong></li>
                </ul>

{{--                <h3>Ocupación por tipo de habitación</h3>--}}
                <ul>
{{--                    @foreach ($byRoomType as $type => $count)--}}
{{--                        <li>{{ $type }}: {{ $count }} habitaciones ocupadas</li>--}}
{{--                    @endforeach--}}
                </ul>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

        });

        function loadReport(){
            location.href = "{{ url('admin/report/consolidated-by-day/') }}/" + $("#rcdDate").val();
        }

    </script>
@endsection
