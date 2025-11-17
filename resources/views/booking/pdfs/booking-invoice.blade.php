<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
    <style>
        body { font-family: sans-serif; }
        h1 { color: #fd7e14; }

        .pdm-h2 {
            color: #4e73df;
            font-size: 20px;
            text-align: center;
        }
        .table-customer {
            width: 99%;
        }

        .table-customer tbody tr td:first-child h5 {
            color: #4e73df;
            padding: 0;
            margin: 0;
        }

        .table-customer tbody tr td:first-child p {
            font-size: 12px;
            padding: 0;
            margin: 2px 0;
        }

        .table-customer tbody tr td:last-child h3 {
            color: #4e73df;
            margin: 0;
            padding: 0;
        }

        .pdm-h5 {
            color: #4e73df;
            margin: 0 2px;
        }

        .table-booking{
            width: 100%;
        }

        .table-details {
            width: 100%;
        }

        .table-details tbody tr td {
            font-size: 12px;
        }

        .table-details tbody tr td:first-child {
            font-weight: 700;
        }

        .table-details tbody tr td:last-child {
            /*font-weight: 700;*/
        }

        .table-details-invoice {
            width: 100%;
        }

        .table-details-invoice tbody tr td {
            font-size: 12px;
        }

        .table-details-invoice tbody tr td:first-child {
            color: #4e73df;
            font-weight: 700;
        }

        .table-details-invoice tbody tr td:last-child {
            text-align: right;

        }

        .table-items{
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            /*overflow: hidden;*/
        }

        .table-items thead {
            background-color: #4e73df;
        }

        .table-items thead tr th {
            font-size: 12px;
            color: white;
            padding: 5px;
        }

        .table-items tbody tr td {
            font-size: 12px;
            padding: 4px;
        }

        .table-items tfoot {
            background-color: #ECF2F2;
        }

        .table-items tfoot tr td {
            font-size: 12px;
            font-weight: 700;
            padding: 5px;
            color: #4e73df;
            text-align: right;

        }
    </style>
</head>
<body>

@include('booking.pdfs.invoice-head')

<table class="table-customer">
    <tbody>
    <tr>
        <td style="width: 75%">
            <h5>Pagado por</h5>
            <p>{{ $receipt->booking->customer->nit_name }}</p>
            <p>{{ $receipt->booking->customer->email }}</p>
        </td>
        <td style="width: 25%; vertical-align: top; text-align: right;">
            <h3>RECIBO</h3>
        </td>
    </tr>
    </tbody>
</table>
<div style="height: 10px"></div>
<h5 class="pdm-h5">Detalle de la reserva</h5>
<table class="table-booking">
    <tbody>
    <tr>
        <td style="width: 65%">
            <table class="table-details">
                <tbody>
                <tr>
                    <td style="width: 30%"></td>
                    <td style="width: 70%"></td>
                </tr>
                <tr>
                    <td>Check-in</td>
                    <td>{{ $receipt->booking->checkin_date }}</td>
                </tr>
                <tr>
                    <td>Check-out</td>
                    <td>{{ $receipt->booking->checkout_date }}</td>
                </tr>
                <tr>
                    <td>Huespedes</td>
                    <td>{{ $receipt->booking->total_adults }} adultos, {{ $receipt->booking->total_children }} niños</td>
                </tr>
                <tr>
                    <td>Unidad</td>
                    <td>{{ $receipt->booking->room->title }}</td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="width: 35%; vertical-align: bottom;">
            <table class="table-details-invoice">
                <tbody>
                <tr>
                    <td style="width: 50%">Recibo #</td>
                    <td style="width: 50%">5</td>
                </tr>
                <tr>
                    <td>Fecha del recibo</td>
                    <td>25/05/2025</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<br>

<table class="table-items">
    <thead>
    <tr>
        <th>Cantidad</th>
        <th>Descripcion</th>
        <th>P. Unitario</th>
        <th>Importe</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="text-align: right">1</td>
        <td>Hospedaje ({{ $receipt->booking->getReservationDaysAttribute() }} Noches)</td>
        <td style="text-align: right">{{ $receipt->booking->total_pay }}</td>
        <td style="text-align: right">{{ $receipt->booking->total_pay }}</td>
    </tr>
    @foreach($receipt->booking->extraSales as $extraSale)
        @if(strcmp($extraSale->status, \App\Models\ExtraSales::STATUS_NO_PAID) == 0)
            <tr>
                <td style="text-align: right">{{$extraSale->quantity}}</td>
                <td>{{$extraSale->product->name}}</td>
                <td style="text-align: right">{{$extraSale->price}}</td>
                <td style="text-align: right">{{$extraSale->sub_total}}</td>
            </tr>
{{--            $total += $extraSale->getSubTotalAttribute();--}}
        @endif

    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <td colspan="3">Total</td>
        <td>{{ $receipt->total }}</td>
    </tr>
    </tfoot>
</table>

</body>
</html>
