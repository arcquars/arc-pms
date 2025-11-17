<!-- Modal create booking -->
<div class="modal fade" id="bookingCreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="bookingCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingCreateModalLabel">Nueva reservación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="mcCollapseActive" name="collapseActive" />
                    <input type="hidden" name="customer[client][id]" />
                    <input type="hidden" name="customer[id]" />
                    <div></div>
                    @csrf
                    <div id="mcbProgress" class="progress mb-2" style="height: 2rem;">
{{--                        <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Cliente</div>--}}
                    </div>
                    <div class="collapse width" id="collapseClient">
                        <h5 class="text-center">1. Datos cliente</h5>
                        <div class="form-group">
                            <label for="c-customer-client-first_name">
                                Nombres <span class="text-danger">*</span>
                                <a href="#" onclick="openSearchPersonModal(); return false;" class="btn btn-link btn-sm"
                                   title="Buscar Cliente"
                                >
                                    <i class="fas fa-search"></i>
                                </a>
                                <a href="#" class="btn btn-link btn-sm" title="Limpiar busqueda"
                                   onclick="clearPersonDatas(); return false;">
                                    <i class="fas fa-eraser"></i>
                                </a>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="c-customer-client-first_name" name="customer[client][first_name]">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-customer-client-last_name_paternal">Apellido paterno <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-client-last_name_paternal" name="customer[client][last_name_paternal]">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="c-customer-client-last_name_maternal">Apellido materno</label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-client-last_name_maternal" name="customer[client][last_name_maternal]">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-customer-client-document_type">Tipo de documento <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" id="c-customer-client-document_type" name="customer[client][document_type]">
                                    <option value="">Seleccione</option>
                                    @foreach(config('bookings.document_type') as $documentType)
                                        <option value="{{$documentType}}">{{$documentType}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="c-customer-client-document">Documento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-client-document" name="customer[client][document]">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="c-customer-client-document_complement">Cmpl</label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-client-document_complement" name="customer[client][document_complement]">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-customer-nit">NIT</label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-nit" name="customer[nit]">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="c-customer-nit_name">Nombre factura</label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-nit_name" name="customer[nit_name]">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-customer-email">Correo</label>
                                <input type="email" class="form-control form-control-sm" id="c-customer-email" name="customer[email]">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="c-customer-phone">Telefono</label>
                                <input type="text" class="form-control form-control-sm" id="c-customer-phone" name="customer[phone]">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="c-send_email" value="1" name="booking[send_email]">
                            <label class="form-check-label" for="c-send_email">Enviar estado de cuenta por correo</label>
                        </div>
                    </div>
                    <div class="collapse width" id="collapseHosting">
                        <h5 class="text-center">2. Datos del alojamiento</h5>
                        <div class="form-group">
                            <label for="c-booking-room">Habitacion</label>
                            <select class="form-control form-control-sm" id="c-booking-room" name="booking[room]">
                                <option value="">Seleccione</option>
                                @foreach($roomLevels as $roomLevel)
                                    <optgroup label="{{$roomLevel->name}}">
                                        @foreach($roomLevel->rooms as $room)
                                        <option value="{{$room->id}}">{{$room->title}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-booking-checkin_date">Fecha entrada</label>
                                <input type="datetime-local" class="form-control form-control-sm" id="c-booking-checkin_date" name="booking[checkin_date]">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="c-booking-checkout_date">Fecha salida</label>
                                <input type="datetime-local" class="form-control form-control-sm" id="c-booking-checkout_date" name="booking[checkout_date]">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-booking-total_adults">Adultos</label>
                                <input type="number" class="form-control form-control-sm" id="c-booking-total_adults" name="booking[total_adults]">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="c-booking-total_children">Niños</label>
                                <input type="number" class="form-control form-control-sm" id="c-booking-total_children" name="booking[total_children]">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse width" id="collapseCost">
                        <h5 class="text-center">3. Costo</h5>
                        <input type="hidden" name="booking[reservationDay]">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="c-cost-discount">
                                    Descuento
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  type="radio" name="cost[discount_type]" checked id="c-cost-discount_type_percent" value="1">
                                        <label class="form-check-label" for="c-cost-discount_type_percent">%</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cost[discount_type]" id="c-discount_type_percent_money" value="2">
                                        <label class="form-check-label" for="c-discount_type_percent">Bs.</label>
                                    </div>
                                </label>
                                <div id="cSectionDiscount" class="input-group input-group-sm">
                                    <select name="cost[discount]" id="c-cost-discount" class="form-control" onchange="calculateCost();">
                                        <option value="">Seleccione...</option>
                                        @foreach(config('bookings.discounts') as $discount)
                                            <option value="{{$discount}}">{{$discount}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="c-cost-extra_charge">Cobro extra</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="c-cost-extra_charge" name="cost[extra_charge]" onchange="calculateCost();">
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
                                    <input type="text" class="form-control form-control-sm" id="c-cost-forward" name="cost[forward]" onchange="showCreateMethodPayment(this);">
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="hidden" id="costTotal" name="cost_total">
                                <label for="c-cost-total_pay">Total a pagar</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ config('bookings.money') }}</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="c-cost-total_pay" name="cost[total_pay]" readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <p id="c-display-reservation-day" class="text-info text-sm-center"></p>
                            </div>
                        </div>
                        <div id="cGroupForwardMethodPayment" class="form-group">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Metodo de pago</div>
                                </div>
                                <select name="booking[forward_method_payment]" id="c-booking-forward_method_payment" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach(config('bookings.method_payment') as $mpayment)
                                        <option value="{{$mpayment}}">{{__('hotel-manager.'.$mpayment)}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="c-booking-comments">Observaciones</label>
                            <textarea class="form-control form-control-sm" id="c-booking-comments" name="booking[comments]" ></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary btn-sm" type="button" value="1" onclick="actionBack();">
                        Atras
                    </button>
                    <button class="btn btn-primary btn-sm" type="button" value="1" onclick="actionNext();" id="mcbBtnNext">
                        Siguiente
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/template" id="template_c_discount">
    <% if (obj.type === 1) { %>
    <select name="cost[discount]" id="c-cost-discount" class="form-control" onchange="calculateCost();">
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
    <input type="number" name="cost[discount]" id="c-cost-discount" class="form-control form-control-sm" onchange="calculateCost();" >
    <div class="invalid-feedback"></div>
    <% } %>
</script>
@push('js')
    <script>
        $( document ).ready(function() {
            $('#bookingCreateModal form input[type="text"]').keyup(function()
            {
                $(this).val($(this).val().toUpperCase());
            });

            $("input[name='cost[discount_type]']").on('change', function(){
                const typeDiscount = parseInt($(this).val());
                $("input[name='cost[discount]']").val("");
                $("select[name='cost[discount]']").val("");
                calculateCost();
                const info = {
                    type: typeDiscount
                }
                const templateCdiscount = _.template($("#template_c_discount").html());
                $("#cSectionDiscount").empty().append(templateCdiscount(info));
            });
        });

        function openBookingCreateModal(reserveDate){
            $("#bookingCreateModal form")[0].reset();
            $("#bookingCreateModal form input[name='customer[client][id]']").val("");
            $("#bookingCreateModal form input[name='customer[id]']").val("");

            if(reserveDate !== null){
                $("#bookingCreateModal form input[name='booking[checkin_date]']").val(reserveDate);
            } else {
                $("#bookingCreateModal form input[name='booking[checkin_date]']").val("");
            }

            $('#collapseClient').collapse('show');
            $('#collapseHosting').collapse('hide');
            $('#collapseCost').collapse('hide');
            $("#mcCollapseActive").val(1);
            $("#mcbBtnNext").empty().text("Siguiente");
            $("#mcbProgress").empty().append(progressState(1));
            $('#bookingCreateModal').modal('show');
        }

        function actionNext(){
            const panelActive = parseInt($("#mcCollapseActive").val());
            clearErrorInputs();
            toggleButtons(false);
            switch (panelActive) {
                case 1:
                    $.ajax({
                        url:"{{route('customer.a.create.validate.customer')}}",
                        type: 'post',
                        data : $("#bookingCreateModal form").serialize(),
                        dataType:'json',
                        beforeSend:function(){
                            toggleButtons(true);
                        },
                        success:function(res){
                            $('#collapseClient').collapse('hide');
                            $('#collapseHosting').collapse('show');
                            $('#collapseCost').collapse('hide');
                            $("#mcbProgress").empty().append(progressState(2));
                            $("#mcCollapseActive").val(2);

                            // $("#bookingCreateModal form booking[checkin_date]").val(res.checkin);
                            $("#bookingCreateModal form input[name='booking[checkin_date]']").val(res.checkin);
                            $("#bookingCreateModal form input[name='booking[checkout_date]']").val(res.checkout);
                        },
                        error: function (data) {
                            const errors = data.responseJSON.errors;
                            $.each(errors, function (key, values) {
                                const propertyId = '#c-' + key.replaceAll('.', '-');
                                let errorLis = "<ul style='padding-left: 4px;'>";
                                $.each(values, function(k, value){
                                    errorLis += "<li>"+value+"</li>";
                                });
                                errorLis += "</ul>";
                                $(propertyId).addClass('is-invalid');
                                $(propertyId).next().empty().append(errorLis);

                            });
                        }

                    });
                    break;
                case 2:
                    $.ajax({
                        url:"{{route('customer.a.create.validate.booking')}}",
                        type: 'post',
                        data : $("#bookingCreateModal form").serialize(),
                        dataType:'json',
                        beforeSend:function(){
                            toggleButtons(true);
                        },
                        success:function(res){
                            $('#collapseClient').collapse('hide');
                            $('#collapseHosting').collapse('hide');
                            $('#collapseCost').collapse('show');
                            $("#mcbProgress").empty().append(progressState(3));
                            $("#mcCollapseActive").val(3);
                            $("#mcbBtnNext").empty().text("Grabar");
                            $("#c-cost-total_pay").val(res.roomType.price * res.reservationDays);
                            $("#costTotal").val(res.roomType.price * res.reservationDays);
                            $("#c-display-reservation-day").empty().text("(Precio hab: " + res.roomType.price + " | Dias: " + res.reservationDays + ")");
                            $("input[name='booking[reservationDay]']").val(res.reservationDays);
                        },
                        error: function (data) {
                            const errors = data.responseJSON.errors;
                            console.log("error dat:: ", errors);
                            $.each(errors, function (key, values) {
                                const propertyId = '#c-' + key.replaceAll('.', '-');
                                let errorLis = "<ul style='padding-left: 4px;'>";
                                $.each(values, function(k, value){
                                    errorLis += "<li>"+value+"</li>";
                                });
                                errorLis += "</ul>";
                                $(propertyId).addClass('is-invalid');
                                $(propertyId).next().empty().append(errorLis);

                            });
                        }

                    });
                    break;
                case 3:
                    $.ajax({
                        url:"{{route('customer.a.create.validate.cost')}}",
                        type: 'post',
                        data : $("#bookingCreateModal form").serialize(),
                        dataType:'json',
                        beforeSend:function(){
                            toggleButtons(true);
                        },
                        success:function(res){
                            $("#bookingCreateModal").modal('hide');
                            showAlert(res.message.typeIcon, res.message.title);
                            if(eventCalendar !== null){
                                eventCalendar.refetchEvents();
                            }
                        },
                        error: function (data) {
                            if(data.responseJSON.result !== undefined){
                                showAlert(data.responseJSON.message.typeIcon, data.responseJSON.message.title);
                            } else {
                                const errors = data.responseJSON.errors;
                                $.each(errors, function (key, values) {
                                    const propertyId = '#c-' + key.replaceAll('.', '-');
                                    let errorLis = "<ul style='padding-left: 4px;'>";
                                    $.each(values, function(k, value){
                                        errorLis += "<li>"+value+"</li>";
                                    });
                                    errorLis += "</ul>";
                                    $(propertyId).addClass('is-invalid');
                                    $(propertyId).next().empty().append(errorLis);

                                });
                            }
                        }
                    });
                    break;
            }
        }

        function actionBack(){
            const panelActive = parseInt($("#mcCollapseActive").val());
            switch (panelActive) {
                case 1:
                    break;
                case 2:
                    $('#collapseClient').collapse('show');
                    $('#collapseHosting').collapse('hide');
                    $('#collapseCost').collapse('hide');
                    $("#mcbProgress").empty().append(progressState(1));
                    $("#mcCollapseActive").val(1);
                    break;
                case 3:
                    $('#collapseClient').collapse('hide');
                    $('#collapseHosting').collapse('show');
                    $('#collapseCost').collapse('hide');
                    $("#mcbProgress").empty().append(progressState(2));
                    $("#mcCollapseActive").val(2);
                    $("#mcbBtnNext").empty().text("Siguiente");
                    break;
            }
        }

        function progressState(state){
            let htmlProgress = "";
            switch (state) {
                case 1: // #BABCD1
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Cliente</div>';
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 33%; background-color: #BABCD1" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Alojamiento</div>';
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 34%; background-color: #BABCD1" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100">Costo</div>';
                    break;
                case 2:
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Cliente</div>';
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 33%; background-color: #4363C1" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Alojamiento</div>';
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 34%; background-color: #BABCD1" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100">Costo</div>';
                    break;
                case 3:
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Cliente</div>';
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 33%; background-color: #4363C1;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Alojamiento</div>';
                    htmlProgress += '<div class="progress-bar" role="progressbar" style="width: 34%;" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100">Costo</div>';
                    break;
            }

            return htmlProgress;
        }

        function clearErrorInputs(){
            $("#bookingCreateModal form input, select, textarea").removeClass('is-invalid');
            $("#bookingCreateModal form input, select, textarea").next('.invalid-feedback').empty();
            // $("#bookingCreateModal form input").next().empty();
        }

        function calculateCost(){
            let discountType = parseInt($("#bookingCreateModal form input[name='cost[discount_type]']:radio:checked").val());
            let discount = $("#c-cost-discount").val()? parseFloat($("#c-cost-discount").val()) : 0;
            let cCostExtraCharge = $("#c-cost-extra_charge").val()? parseFloat($("#c-cost-extra_charge").val()) : 0;
            let cCostForward = $("#c-cost-forward").val()? parseFloat($("#c-cost-forward").val()) : 0;
            let costTotal = $("#costTotal").val()? parseFloat($("#costTotal").val()) : 0;
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

        function toggleButtons(active){
            if(active){
                $("#bookingCreateModal .modal-footer button").removeAttr('disabled');
            } else {
                $("#bookingCreateModal .modal-footer button").attr('disabled', 'disabled');
            }
        }

        function showCreateMethodPayment(inputForward){
            calculateCost();
            const forward = $(inputForward).val();
            $("#bookingCreateModal form select[name='booking[forward_method_payment]']").val("");
            if(forward && parseInt(forward) > 0){
                $("#cGroupForwardMethodPayment").show();
            } else {
                $("#cGroupForwardMethodPayment").hide();
            }
        }

        function loadCustomerById(customer, person){
            $("#bookingCreateModal form input[name='customer[client][id]']").val(person.id);
            $("#bookingCreateModal form input[name='customer[id]']").val(customer.id);
            $("#bookingCreateModal form input[name='customer[client][first_name]']").val(person.first_name);
            $("#bookingCreateModal form input[name='customer[client][last_name_paternal]']").val(person.last_name_paternal);
            $("#bookingCreateModal form input[name='customer[client][last_name_maternal]']").val(person.last_name_maternal);
            $("#bookingCreateModal form select[name='customer[client][document_type]']").val(person.document_type);
            $("#bookingCreateModal form input[name='customer[client][document]']").val(person.document);
            $("#bookingCreateModal form input[name='customer[client][document_complement]']").val(person.document_complement);
            $("#bookingCreateModal form input[name='customer[nit]']").val(customer.nit);
            $("#bookingCreateModal form input[name='customer[nit_name]']").val(customer.nit_name);
            $("#bookingCreateModal form input[name='customer[email]']").val(customer.email);
            $("#bookingCreateModal form input[name='customer[phone]']").val(customer.mobile);
        }

        function clearPersonDatas(){
            $("#bookingCreateModal form input[name='customer[client][id]']").val("");
            $("#bookingCreateModal form input[name='customer[id]']").val("");
            $("#bookingCreateModal form input[name='customer[client][first_name]']").val("");
            $("#bookingCreateModal form input[name='customer[client][last_name_paternal]']").val("");
            $("#bookingCreateModal form input[name='customer[client][last_name_maternal]']").val("");
            $("#bookingCreateModal form select[name='customer[client][document_type]']").val("");
            $("#bookingCreateModal form input[name='customer[client][document]']").val("");
            $("#bookingCreateModal form input[name='customer[client][document_complement]']").val("");
            $("#bookingCreateModal form input[name='customer[nit]']").val("");
            $("#bookingCreateModal form input[name='customer[nit_name]']").val("");
            $("#bookingCreateModal form input[name='customer[email]']").val("");
            $("#bookingCreateModal form input[name='customer[phone]']").val("");
            clearErrorInputs();
        }
    </script>

@endpush
