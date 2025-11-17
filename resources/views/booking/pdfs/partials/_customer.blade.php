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
