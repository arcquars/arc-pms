@extends('layout')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Consolidado por Rango de fechas:
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.report.consolidated_by_range') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="rcdDateInitial">Fecha inicial:</label>
                            <input type="datetime-local" id="rcdDateInitial" name="date_initial" class="form-control form-control-sm" value="{{ $dateInitial ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="rcdDateEnd">Fecha final:</label>
                            <input type="datetime-local" id="rcdDateEnd" name="date_end" class="form-control form-control-sm" value="{{ $dateEnd ?? '' }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <ul>
                    <li>Total de reservas activas: <strong></strong></li>
{{--                    <li>Ingresos del día: <strong>${{ number_format($totalIncome, 2) }}</strong></li>--}}
                    <li>Check-ins: <strong></strong></li>
                    <li>Check-outs: <strong></strong></li>
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
