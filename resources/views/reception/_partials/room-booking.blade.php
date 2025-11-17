    <h5>Datos del alojamiento</h5>
<hr>
<input type="hidden" name="booking[room]" value="{{ $room_id }}">
<div class="row">
    <div class="col-md-6 form-group">
        <label for="">Fecha y hora entrada</label>
        <input type="datetime-local" name="booking[checkin_date]" class="form-control form-control-sm disabled @error('booking.checkin_date') is-invalid @enderror" value="{{ $startDate }}" readonly>
        @error('booking.checkin_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 form-group">
        <label for="">Fecha y hora de salida</label>
        <input type="datetime-local" name="booking[checkout_date]" class="form-control form-control-sm @error('booking.checkout_date') is-invalid @enderror"
               value="{{old("booking.checkout_date", $endDate )}}" onchange="calculateCosTProcess();">
        @error('booking.checkout_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-booking-total_adults">Adultos</label>
        <input type="number" class="form-control form-control-sm @error('booking.total_adults') is-invalid @enderror" id="c-booking-total_adults"
               name="booking[total_adults]" value="{{old("booking.total_adults")}}">
        @error('booking.total_adults')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 form-group">
        <label for="c-booking-total_children">Niños</label>
        <input type="number" class="form-control form-control-sm" id="c-booking-total_children" name="booking[total_children]">
        <div class="invalid-feedback"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-cost-discount">
            Descuento
            <div class="form-check form-check-inline">
                <input class="form-check-input"  type="radio" name="cost[discount_type]" id="c-cost-discount_type_percent" value="1" {{ old('cost.discount_type') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="c-cost-discount_type_percent">%</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="cost[discount_type]" id="c-discount_type_percent_money" value="2" {{ old('cost.discount_type') == '2' ? 'checked' : '' }}>
                <label class="form-check-label" for="c-discount_type_percent_money">Bs.</label>
            </div>
        </label>
        <div id="cSectionDiscount" class="input-group input-group-sm">
            <select name="cost[discount]" id="c-cost-discount" class="form-control @error('cost.discount') is-invalid @enderror" onchange="calculateCosTProcess();">
                <option value="">Seleccione...</option>
                @foreach(config('bookings.discounts') as $discount)
                    <option value="{{$discount}}">{{$discount}}</option>
                @endforeach
            </select>
            <div class="input-group-prepend">
                <div class="input-group-text">%</div>
            </div>
            @error('cost.discount')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="c-cost-extra_charge">Cobro extra</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">+</div>
            </div>
            <input type="text" class="form-control form-control-sm coste @error('cost.extra_charge') is-invalid @enderror" id="c-cost-extra_charge"
                   name="cost[extra_charge]" onchange="calculateCosTProcess();" value="{{ old('cost.extra_charge', '') }}">
            @error('cost.extra_charge')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
            <input type="text" class="form-control form-control-sm coste @error('cost.forward') is-invalid @enderror" id="c-cost-forward"
                   name="cost[forward]" onchange="showCreateMethodPayment(this);" value="{{old('cost.forward')}}">
            @error('cost.forward')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 form-group">
        <input type="hidden" id="costTotal" name="costTotal" value="{{ $roomType->price }}">
        <label for="c-cost-total_pay">Total a pagar</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ config('bookings.money') }}</div>
            </div>
            <input type="text" class="form-control form-control-sm @error('cost.total_pay') is-invalid @enderror" id="c-cost-total_pay" name="cost[total_pay]"
                   value="{{old('cost.total_pay', $roomType->price)}}" readonly>
            @error('cost.total_pay')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <p id="c-display-reservation-day" class="text-info text-sm-center"></p>
    </div>
</div>
<div id="cGroupForwardMethodPayment" class="form-group">
    <div class="input-group input-group-sm">
        <div class="input-group-prepend">
            <div class="input-group-text">Metodo de pago</div>
        </div>
        <select name="booking[forward_method_payment]" id="c-booking-forward_method_payment" class="form-control @error('booking.forward_method_payment') is-invalid @enderror">
            <option value="">Seleccione...</option>
            @foreach(config('bookings.method_payment') as $mpayment)
                <option value="{{$mpayment}}">{{__('hotel-manager.'.$mpayment)}}</option>
            @endforeach
        </select>
        @error('booking.forward_method_payment')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group">
    <label for="c-booking-comments">Observaciones</label>
    <textarea class="form-control form-control-sm @error('booking.comments') is-invalid @enderror" id="c-booking-comments" name="booking[comments]" >{{old('booking.comments')}}</textarea>
    @error('booking.comments')
    <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>

<script type="text/template" id="template_c_discount">
    <% if (obj.type === 1) { %>
    <select name="cost[discount]" id="c-cost-discount" class="form-control" onchange="calculateCosTProcess();">
        <option value="">Seleccione...</option>
        @foreach(config('bookings.discounts') as $discount)
            <option value="{{$discount}}">{{$discount}}</option>
        @endforeach
    </select>
    <div class="input-group-prepend">
        <div class="input-group-text">%</div>
    </div>
    <div class="invalid-feedback"></div>
    <% } else { %>
    <div class="input-group-prepend">
        <div class="input-group-text">{{ config('bookings.money') }}</div>
    </div>
    <input type="number" name="cost[discount]" id="c-cost-discount" class="form-control form-control-sm" onchange="calculateCosTProcess();" >
    <div class="invalid-feedback"></div>
    <% } %>
</script>

@prepend('js')
    <script>
        $(document).ready(function(){
            $("input[name='cost[discount_type]']").on('change', function(){
                const discountType = parseInt($(this).val());
                $("input[name='cost[discount]']").val("");
                $("select[name='cost[discount]']").val("");
                setDiscountHtml(discountType);
                calculateCosTProcess();
            });

            const discountType = "{{ old('cost.discount_type') }}"
            const discount = "{{old('cost.discount')}}";
            setDiscount(discountType, discount);


            const costForward = ("{{ old('cost.forward') }}" !== "")? parseFloat("{{ old('cost.forward') }}") : 0;
            const forwardMethod = "{{ old("booking.forward_method_payment") }}";
            setForwardPayment(costForward, forwardMethod);


            if($("#c-cost-forward").val() !== ''){
                $("#cGroupForwardMethodPayment").css('display','block');
            } else {
                $("#cGroupForwardMethodPayment").css('display', 'none');
            }
        });

        function showCreateMethodPayment(inputForward){
            calculateCosTProcess();
            const forward = $(inputForward).val();
            $("select[name='booking[forward_method_payment]']").val("");
            if(forward && parseInt(forward) > 0){
                $("#cGroupForwardMethodPayment").css('display','block');
            } else {
                $("#cGroupForwardMethodPayment").css('display', 'none');
            }
        }

        function calculateCosTProcess(){
            let days = 1;
            const checkoutDate = $("input[name='booking[checkout_date]']").val();
            if(checkoutDate !== ""){
                const checkinDate = $("input[name='booking[checkin_date]']").val();
                const inDate = moment(checkinDate, moment.DATETIME_LOCAL);
                const outDate = moment(checkoutDate, moment.DATETIME_LOCAL);
                days = Math.ceil(outDate.diff(inDate, "days", true));
                if(days <1){
                    $("input[name='booking[checkout_date]']").val("");
                    days = 1;
                }
            }

            $("#c-display-reservation-day").empty().text("(Precio hab: " + $("#costTotal").val() + " | Dias: " + days + ")");

            let discountType = parseInt($("input[name='cost[discount_type]']:radio:checked").val());
            let discount = $("#c-cost-discount").val()? parseFloat($("#c-cost-discount").val()) : 0;
            let cCostExtraCharge = $("#c-cost-extra_charge").val()? parseFloat($("#c-cost-extra_charge").val()) : 0;
            let cCostForward = $("#c-cost-forward").val()? parseFloat($("#c-cost-forward").val()) : 0;
            let costTotal = $("#costTotal").val()? parseFloat($("#costTotal").val()) * days : 0;
            let total = 0;
            if(discountType === 1){
                if(discount === 0){
                    total = costTotal + cCostExtraCharge - cCostForward;
                } else {
                    total = (costTotal - (costTotal * discount / 100)) + cCostExtraCharge - cCostForward;
                }
            } else {
                total = costTotal + cCostExtraCharge - cCostForward - discount;
            }
            $("#c-cost-total_pay").val(total.toFixed(2));
        }

        function setDiscount(discountType, discount) {
            setDiscountHtml((discountType !== "")? parseInt(discountType): 1);
            switch (discountType) {
                case "2":
                    $("#c-discount_type_percent_money").prop('checked', true);
                    $("#c-cost-discount").val(discount);
                    break;
                default:
                    $("#c-cost-discount_type_percent").prop('checked', true);
                    $("#c-cost-discount").val(discount);
                    break;
            }
        }

        function setDiscountHtml(discountType) {
            const info = {
                type: discountType
            }
            const templateCdiscount = _.template($("#template_c_discount").html());
            $("#cSectionDiscount").empty().append(templateCdiscount(info));
        }

        function setForwardPayment(costForward, methodPayment) {
            if(costForward > 0){
                $("#cGroupForwardMethodPayment").css("display", "block");
                $("#c-booking-forward_method_payment").val(methodPayment);
            } else {
                $("#cGroupForwardMethodPayment").css("display", "none");
                $("#c-booking-forward_method_payment").val("");
            }
        }
    </script>
@endprepend
