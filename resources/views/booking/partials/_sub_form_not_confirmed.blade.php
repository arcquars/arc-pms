<?php
use App\Models\Booking;
/** @var Booking $booking */
?>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-cost-discount">
            Descuento
            <div class="form-check form-check-inline">
                <input class="form-check-input"  type="radio" name="cost[discount_type]"
                       @if($booking->discount_type != 2) checked @endif id="c-cost-discount_type_percent" value="1"
                       onchange="showTypeDiscount(this)"
                />
                <label class="form-check-label" for="c-cost-discount_type_percent">%</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="cost[discount_type]"
                       @if($booking->discount_type == 2) checked @endif id="c-discount_type_percent_money" value="2"
                       onchange="showTypeDiscount(this)"
                />
                <label class="form-check-label" for="c-discount_type_percent_money">Bs.</label>
            </div>
        </label>
        <div class="input-group input-group-sm c-section-discount">
            @if($booking->discount_type != 2)
            <select name="cost[discount]" id="c-cost-discount" class="form-control" onchange="calculateCost();">
                <option value="">Seleccione...</option>
                @foreach(config('bookings.discounts') as $discount)
                    <option value="{{$discount}}" @if($booking->discount == $discount) selected @endif>{{$discount}}</option>
                @endforeach
            </select>
            <div class="input-group-prepend">
                <div class="input-group-text">%</div>
            </div>
            @else
                <div class="input-group-prepend">
                    <div class="input-group-text">Bs</div>
                </div>
                <input type="number" name="cost[discount]" id="e-cost-discount" class="form-control form-control-sm"
                       onchange="calculateCostEdit();" value="{{$booking->discount}}"
                />
            @endif
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="c-cost-extra_charge">Cobro extra</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">+</div>
            </div>
            <input type="text" class="form-control form-control-sm" id="c-cost-extra_charge" name="cost[extra_charge]"
                   onchange="calculateCost();"
                   value="{{ $booking->extra_charge }}"
            />
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-cost-forward">Adelanto</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ config('bookings.money') }}</div>
            </div>
            <input type="text" class="form-control form-control-sm" id="c-cost-forward" name="cost[forward]"
                   value="{{ $booking->forward }}" onchange="calculateCost()"
            />
        </div>
        <div class="invalid-feedback"></div>
    </div>
    <div id="cGroupForwardMethodPayment" class=" col-md-6 form-group">
        <label for="">Metodo de pago</label>
        <select name="booking[forward_method_payment]" id="c-booking-forward_method_payment" class="form-control form-control-sm">
            <option value="">Seleccione...</option>
            @foreach(config('bookings.method_payment') as $mpayment)
                <option value="{{$mpayment}}">{{__('hotel-manager.'.$mpayment)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback c-booking-forward_method_payment"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-cost-total_pay">Costo <small>(Dias: {{ $booking->getReservationDaysAttribute() }})</small></label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ config('bookings.money') }}</div>
            </div>
            <input type="text" class="form-control form-control-sm" id="costTotal" name="cost[total]"
                   style="background-color: #DBE0F4;" value="{{$booking->cost}}" readonly
            />
            <div class="invalid-feedback"></div>
        </div>
        <p id="c-display-reservation-day" class="text-info text-sm-center"></p>
    </div>
    <div class="col-md-6 form-group">
        <label for="c-cost-total_pay">Total a pagar</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ config('bookings.money') }}</div>
            </div>
            <input type="text" class="form-control form-control-sm" id="c-cost-total_pay"
                   style="background-color: #DBE0F4;" value="{{$booking->total_pay}}" name="cost[total_pay]" readonly
            />
            <div class="invalid-feedback"></div>
        </div>
        <p id="c-display-reservation-day" class="text-info text-sm-center"></p>
    </div>
</div>
<div class="form-group">
    <label for="c-booking-comments">Observaciones</label>
    <textarea class="form-control form-control-sm" id="c-booking-comments" name="booking[comments]" >{{ $booking->comments }}</textarea>
    <div class="invalid-feedback"></div>
</div>
