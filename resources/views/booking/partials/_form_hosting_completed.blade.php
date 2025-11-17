<div id="formHostingCompleted">
    <hr class="m-1">
    <div class="w-100 bg-gradient-primary p-2 mt-2">
        <h5 class="m-0 text-white">Costo del alojamiento</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th>Cobro extra</th>
                <th>Costo Calculado</th>
                <th>Adelanto</th>
                <th>Penalidad</th>
                <th>Por pagar</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$booking->extra_charge}} {{ config('bookings.money') }}</td>
                <td>{{$booking->calculated_cost}} {{ config('bookings.money') }}</td>
                <td>
                    @if($booking->forward)
                        {{$booking->forward}} {{ config('bookings.money') }}
                        <small>({{ __('hotel-manager.'.$booking->forward_method_payment) }})</small>
                    @else
                        --
                    @endif
                </td>
                <td>
                    <input type="hidden" name="total_pay" value="{{$booking->total_pay - $booking->penalty}}">
                    <input type="hidden" name="extra_sales_not_paid_total"
                           value="{{ $booking->getExtraSalesNotPaidTotal() }}">
                    <input type="number" min="0" step="0.01" id="c-penalty"
                           class="form-control form-control-sm text-right @error('penalty') is-invalid @enderror "
                           @if(!$formActive) disabled
                           @endif value="{{old('penalty', $booking->penalty)}}" name="penalty"
                           onchange="recalculateTotal();">
                    <div class="invalid-feedback">
                        @error('penalty')
                        {{ $message }}
                        @enderror
                    </div>
                </td>
                <td class="text-right"><span
                        id="bTotalPay">{{$booking->total_pay- $booking->penalty}}</span> {{ config('bookings.money') }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    @if(count($booking->extraSales) > 0)
        <div class="w-100 bg-gradient-primary p-2 mt-2">
            <h5 class="m-0 text-white">Servicio al cuarto</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Producto/Servicio</th>
                    <th>Precio U.</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($booking->extraSales as $extraSale)
                    <tr>
                        <td>{{$extraSale->product->name}}</td>
                        <td>{{$extraSale->price}} {{ config('bookings.money') }}</td>
                        <td>{{$extraSale->quantity}}</td>
                        <td>
                            <p class="@if((strcmp($extraSale->status, \App\Models\ExtraSales::STATUS_PAID) == 0)) text-success @else text-danger @endif m-0">
                                {{__('hotel-manager.'.$extraSale->status)}}
                                @if((strcmp($extraSale->status, \App\Models\ExtraSales::STATUS_PAID) == 0))
                                    <small>({{ __('hotel-manager.'.$extraSale->receipt->payment_method) }}
                                        )</small>
                                @endif
                            </p>
                        </td>
                        <td class="text-right">
                            @if((strcmp($extraSale->status, \App\Models\ExtraSales::STATUS_PAID) == 0))
                                <s>{{$extraSale->sub_total}} {{ config('bookings.money') }}</s>
                            @else
                                {{$extraSale->sub_total}} {{ config('bookings.money') }}
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total servicio al cuarto</th>
                    <td colspan="2" class="text-right"><b>{{ $booking->getExtraSalesNotPaidTotal() }}</b></td>
                </tr>
                </tfoot>
            </table>
        </div>
    @else
        <p><b>Sin servicios al cuarto</b></p>
    @endif

    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <tfoot>
            <tr>
                <th colspan="3" class="text-right">TOTAL</th>
                <td colspan="2">
                    <input type="text" class="form-control form-control-sm text-right" min="0" readonly
                           name="total"
                           value="{{ $booking->total_pay + $booking->getExtraSalesNotPaidTotal() }}">
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"></td>
                <td colspan="2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-money-bill"></i></div>
                        </div>
                        <select name="method_payment" id="c-method_payment"
                                class="form-control @error('method_payment') is-invalid @enderror"
                                @if(!$formActive) disabled @endif >
                            <option value="">Seleccione...</option>
                            @foreach(config('bookings.method_payment') as $mpayment)
                                <option value="{{$mpayment}}"
                                        @if(strcmp($mpayment, old('method_payment', $booking->final_payment_method)) == 0) selected @endif>{{__('hotel-manager.'.$mpayment)}}</option>
                            @endforeach
                        </select>

                        <div class="invalid-feedback">
                            @error('method_payment')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
