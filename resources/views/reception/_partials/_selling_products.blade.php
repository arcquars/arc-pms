@include('booking.include.header_details_booking', ['booking' => $booking])
@csrf
<input type="hidden" name="booking_id" value="{{$booking->id}}">
<div class="errors"></div>
<hr>
<div class="form-inline mb-2">
    <label class="sr-only" for="inlineSelectProduct">Product</label>
    <div class="input-group input-group-sm">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-store-alt"></i></div>
        </div>
        <select class="form-control" id="inlineSelectProduct">
            @foreach($categoriesAndProducts as $category)
                <optgroup label="{{$category['name']}}">
                    @foreach($category['products'] as $product)
                        <option value="{{$product['id']}}">{{$product['name']}}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
    <button type="button" class="btn btn-primary btn-sm ml-2" onclick="addProductTable($('#inlineSelectProduct')); return false;">Agregar</button>
</div>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-arc">
        <thead class="table-primary">
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Precio Unit.</th>
            <th class="text-center">Precio Total</th>
            <th class="text-center">Eliminar</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-6 text-right">
        <p><b>TOTAL</b></p>
    </div>
    <div class="col-md-6">
        <p class="total-all"></p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" onchange="showPaymentType(this);" id="exampleRadios1" value="now" >
            <label class="form-check-label" for="exampleRadios1">
                Pagar Ahora
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="exampleRadios2" onchange="showPaymentType(this);" value="after" checked>
            <label class="form-check-label" for="exampleRadios2">
                Pagar Despues
            </label>
        </div>

        <div class="form-inline d-payment-type" style="display: none">
            <label class="sr-only" for="inlineFormInputGroupUsername2">Metodo de pago</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-money-check-alt"></i></div>
                </div>
{{--                <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Username">--}}
                <select name="payment_type" class="form-control form-control-sm">
                    <option value="">Metodo de pago</option>
                    @foreach($paymentMethods as $paymentMethod)
                        <option value="{{$paymentMethod}}">{{ __('hotel-manager.'.$paymentMethod) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
