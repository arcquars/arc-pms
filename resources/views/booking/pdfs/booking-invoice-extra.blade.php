<!DOCTYPE html>
<html>
<head>
    <title>Recibo</title>
    @include('booking.pdfs.partials._styles')
</head>
<body>

@include('booking.pdfs.invoice-head')
@include('booking.pdfs.partials._customer', ['receipt' => $receipt])
<div style="height: 10px"></div>
@include('booking.pdfs.partials._booking', ['receipt' => $receipt])
<div style="height: 10px"></div>
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
    @foreach($receipt->extraSales as $extraSale)
        @if(strcmp($extraSale->status, \App\Models\ExtraSales::STATUS_NO_PAID) != 0)
            <tr>
                <td style="text-align: right">{{$extraSale->quantity}}</td>
                <td>{{$extraSale->product->name}}</td>
                <td style="text-align: right">{{$extraSale->price}}</td>
                <td style="text-align: right">{{$extraSale->sub_total}}</td>
            </tr>
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
