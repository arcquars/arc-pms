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
                    <td style="width: 50%">{{ $receipt->id }}</td>
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
