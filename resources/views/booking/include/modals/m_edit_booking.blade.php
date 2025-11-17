<!-- Modal create booking -->
<div class="modal fade" id="bookingEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="bookingEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="updateBookingModal(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingEditModalLabel">Editar reservación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="customer[client][id]" />
                    <input type="hidden" name="customer[id]" />
                    <h5 class="text-center">1. Datos cliente</h5>
                    <div class="form-group">
                        <label for="e-customer-client-first_name">Nombres <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="e-customer-client-first_name"
                               name="customer[client][first_name]" aria-describedby="e-customer-client-first_name-feedback">
                        <div id="e-customer-client-first_name-feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-customer-client-last_name_paternal">Apellido paterno <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-client-last_name_paternal"
                                   name="customer[client][last_name_paternal]" aria-describedby="e-customer-client-last_name_paternal-feedback" />
                            <div id="e-customer-client-last_name_paternal-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e-customer-client-last_name_maternal">Apellido materno</label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-client-last_name_maternal"
                                   name="customer[client][last_name_maternal]" aria-describedby="e-customer-client-last_name_maternal-feedback" />
                            <div id="e-customer-client-last_name_maternal-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-customer-client-document_type">Tipo de documento <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="e-customer-client-document_type"
                                    name="customer[client][document_type]" aria-describedby="e-customer-client-document_type-feedback">
                                <option value="">Seleccione</option>
                                @foreach(config('bookings.document_type') as $documentType)
                                    <option value="{{$documentType}}">{{$documentType}}</option>
                                @endforeach
                            </select>
                            <div id="e-customer-client-document_type-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="e-customer-client-document">Documento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-client-document"
                                   name="customer[client][document]" aria-describedby="e-customer-client-document-feedback" />
                            <div id="e-customer-client-document-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="e-customer-client-document_complement">Cmpl</label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-client-document_complement"
                                   name="customer[client][document_complement]" aria-describedby="e-customer-client-document_complement-feedback" />
                            <div id="e-customer-client-document_complement-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-customer-nit">NIT</label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-nit"
                                   name="customer[nit]" aria-describedby="e-customer-nit-feedback" />
                            <div id="e-customer-nit-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e-customer-nit_name">Nombre factura</label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-nit_name"
                                   name="customer[nit_name]" aria-describedby="e-customer-nit_name-feedback" />
                            <div id="e-customer-nit_name-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-customer-email">Correo</label>
                            <input type="email" class="form-control form-control-sm" id="e-customer-email"
                                   name="customer[email]" aria-describedby="e-customer-email-feedback" />
                            <div id="e-customer-email-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e-customer-phone">Telefono</label>
                            <input type="text" class="form-control form-control-sm" id="e-customer-phone"
                                   name="customer[phone]" aria-describedby="e-customer-phone-feedback">
                            <div id="e-customer-phone-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="e-send_email" value="1" name="booking[send_email]">
                        <label class="form-check-label" for="e-send_email">Enviar estado de cuento por correo</label>
                    </div>
                    <h5 class="text-center">2. Datos del alojamiento</h5>
                    <input type="hidden" name="booking[id]" value="">
                    <div class="form-group">
                        <label for="e-booking-room">Habitacion</label>
                        <select class="form-control form-control-sm" id="e-booking-room"
                                name="booking[room]" aria-describedby="e-booking-room-feedback">
                            <option value="">Seleccione</option>
                            @foreach($roomLevels as $roomLevel)
                                <optgroup label="{{$roomLevel->name}}">
                                    @foreach($roomLevel->rooms as $room)
                                        <option value="{{$room->id}}">{{$room->title}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <div id="e-booking-room-feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-booking-checkin_date">Fecha entrada</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="e-booking-checkin_date"
                                   name="booking[checkin_date]" onchange="calculateCostEdit();" aria-describedby="e-booking-checkin_date-feedback">
                            <div id="e-booking-checkin_date-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e-booking-checkout_date">Fecha salida</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="e-booking-checkout_date"
                                   name="booking[checkout_date]" onchange="calculateCostEdit();" aria-describedby="e-booking-checkout_date-feedback">
                            <div id="e-booking-checkout_date-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-booking-total_adults">Adultos</label>
                            <input type="number" class="form-control form-control-sm" id="e-booking-total_adults"
                                   name="booking[total_adults]" aria-describedby="e-booking-total_adults-feedback">
                            <div id="e-booking-total_adults-feedback" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e-booking-total_children">Niños</label>
                            <input type="number" class="form-control form-control-sm" id="e-booking-total_children"
                                   name="booking[total_children]" aria-describedby="e-booking-total_children-feedback">
                            <div id="e-booking-total_children-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <h5 class="text-center">3. Costo</h5>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-cost-discount">
                                Descuento
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="cost[discount_type]" id="e-cost-discount_type_percent" value="1">
                                    <label class="form-check-label" for="e-cost-discount_type_percent">%</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="cost[discount_type]" id="e-discount_type_percent_money" value="2">
                                    <label class="form-check-label" for="e-discount_type_percent">Bs.</label>
                                </div>
                            </label>
                            <div id="eSectionDiscount" class="input-group input-group-sm">
                                <select name="cost[discount]" id="e-cost-discount" class="form-control"
                                        onchange="calculateCostEdit();" aria-describedby="e-cost-discount-feedback">
                                    <option value="">Seleccione...</option>
                                    @foreach(config('bookings.discounts') as $discount)
                                        <option value="{{$discount}}">{{$discount}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                                <div id="e-cost-discount-feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e-cost-extra_charge">Cobro extra</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+</div>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="e-cost-extra_charge"
                                       name="cost[extra_charge]" onchange="calculateCostEdit();" aria-describedby="e-cost-extra_charge-feedback">
                                <div id="e-cost-extra_charge-feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e-cost-forward">Adelanto</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ config('bookings.money') }}</div>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="e-cost-forward" name="cost[forward]"
                                       onchange="showMethodPayment(this);" aria-describedby="e-cost-forward-feedback" />
                                <div id="e-cost-forward-feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="hidden" id="eRoomPrice">
                            <label for="e-cost-total_pay">Total a pagar</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ config('bookings.money') }}</div>
                                </div>
                                <input type="text" class="form-control form-control-sm" id="e-cost-total_pay"
                                       name="cost[total_pay]" aria-describedby="e-cost-total_pay-feedback" readonly>
                                <div id="e-cost-total_pay-feedback" class="invalid-feedback"></div>
                            </div>
                            <p id="e-display-reservation-day" class="text-info text-sm-center">(Precio hab: <span id="eSpanCosteRoom"></span> | Dias: <span id="eSpanReservationDays"></span>)</p>
                        </div>
                    </div>
                    <div id="eGroupForwardMethodPayment" class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Metodo de pago</div>
                            </div>
                            <select name="booking[forward_method_payment]" id="e-booking-forward_method_payment"
                                    class="form-control" aria-describedby="e-booking-forward_method_payment-feedback">
                                <option value="">Seleccione...</option>
                                @foreach(config('bookings.method_payment') as $mpayment)
                                    <option value="{{$mpayment}}">{{__('hotel-manager.'.$mpayment)}}</option>
                                @endforeach
                            </select>
                            <div id="e-booking-forward_method_payment-feedback" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e-booking-comments">Observaciones</label>
                        <textarea class="form-control form-control-sm" id="e-booking-comments" name="booking[comments]"
                        aria-describedby="e-booking-comments-feedback"></textarea>
                        <div id="e-booking-comments-feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="e-booking_status">Estado</label>
                        <select name="booking[status]" id="e-booking_status"
                                class="form-control form-control-sm" aria-describedby="e-booking_status-feedback">
                            <option value="">Seleccione...</option>
                            @foreach(config('bookings.booking_status') as $status)
                                <option value="{{$status}}">{{__('hotel-manager.'.$status)}}</option>
                            @endforeach
                        </select>
                        <div id="e-booking_status-feedback" class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer d-flex bd-highlight">
                    <button type="button" class="btn btn-secondary btn-sm mr-auto p-2 bd-highlight" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary btn-sm p-2 bd-highlight" type="submit" value="update" name="action" >Actualizar</button>
                    <button type="button" class="btn btn-danger btn-sm p-2 bd-highlight" value="delete" onclick="aBookingDelete();" >Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/template" id="template_e_discount">
    <% if (obj.type === 1) { %>
    <select name="cost[discount]" id="e-cost-discount" class="form-control" onchange="calculateCostEdit();">
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
    <input type="number" name="cost[discount]" id="e-cost-discount" class="form-control form-control-sm" onchange="calculateCostEdit();" >
    <div class="invalid-feedback"></div>
    <% } %>
</script>
@push('js')
    <script>
        $( document ).ready(function() {
            $("#bookingEditModal input[name='cost[discount_type]']").on('change', function(){
                const typeDiscount = parseInt($(this).val());
                $("#bookingEditModal input[name='cost[discount]']").val("");
                $("#bookingEditModal select[name='cost[discount]']").val("");
                const info = {
                    type: typeDiscount
                }
                const templateCdiscount = _.template($("#template_e_discount").html());
                $("#eSectionDiscount").empty().append(templateCdiscount(info));
                calculateCostEdit();
            });
        });

        function openbookingEditModal(eventId){
            $("#bookingEditModal form")[0].reset();
            clearEditErrorInputs();
            $.ajax({
                url:"{{route('admin.booking.a_get_by_id')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    booking_id: eventId},
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    // Person
                    $("#bookingEditModal form input[name='customer[client][id]']").val(res.person.id);
                    $("#bookingEditModal form input[name='customer[client][first_name]']").val(res.person.first_name);
                    $("#bookingEditModal form input[name='customer[client][last_name_paternal]']").val(res.person.last_name_paternal);
                    $("#bookingEditModal form input[name='customer[client][last_name_maternal]']").val(res.person.last_name_maternal);
                    $("#bookingEditModal form select[name='customer[client][document_type]']").val(res.person.document_type);
                    $("#bookingEditModal form input[name='customer[client][document]']").val(res.person.document);
                    $("#bookingEditModal form input[name='customer[client][document_complement]']").val(res.person.document_complement);
                    // Customer
                    $("#bookingEditModal form input[name='customer[id]']").val(res.customer.id);
                    $("#bookingEditModal form input[name='customer[nit]']").val(res.customer.nit);
                    $("#bookingEditModal form input[name='customer[nit_name]']").val(res.customer.nit_name);
                    $("#bookingEditModal form input[name='customer[email]']").val(res.customer.email);
                    $("#bookingEditModal form input[name='customer[phone]']").val(res.customer.mobile);
                    // booking
                    if(res.booking.send_email === 1){
                        $("#bookingEditModal form input[name='booking[send_email]']").attr('checked', 'checked');
                    } else {
                        $("#bookingEditModal form input[name='booking[send_email]']").removeAttr('checked');
                    }
                    $("#bookingEditModal form input[name='booking[id]']").val(res.booking.id);
                    $("#bookingEditModal form select[name='booking[room]']").val(res.booking.room_id);
                    $("#bookingEditModal form input[name='booking[checkin_date]']").val(res.booking.checkin_date);
                    $("#bookingEditModal form input[name='booking[checkout_date]']").val(res.booking.checkout_date);
                    $("#bookingEditModal form input[name='booking[total_adults]']").val(res.booking.total_adults);
                    $("#bookingEditModal form input[name='booking[total_children]']").val(res.booking.total_children);
                    $("#eSpanCosteRoom").empty().text(res.roomType.price);
                    $("#eSpanReservationDays").empty().text(res.booking.reservation_days);
                    // Booking Coste
                    const radiosDiscType = $("#bookingEditModal form input[name='cost[discount_type]']");
                    $.each(radiosDiscType, function(index, radio){
                        if(parseInt($(radio).val()) === res.booking.discount_type)
                            $(radio).attr('checked', 'checked');
                    });
                    const info = {
                        type: res.booking.discount_type
                    }
                    const templateCdiscount = _.template($("#template_e_discount").html());
                    $("#eSectionDiscount").empty().append(templateCdiscount(info));
                    if(res.booking.discount_type === 1){
                        $("#bookingEditModal form select[name='cost[discount]").val(res.booking.discount);
                    } else {
                        $("#bookingEditModal form input[name='cost[discount]").val(res.booking.discount);
                    }
                    $("#bookingEditModal form input[name='cost[extra_charge]").val(res.booking.extra_charge);

                    $("#bookingEditModal form input[name='cost[forward]").val(res.booking.forward);
                    $("#bookingEditModal form select[name='booking[forward_method_payment]").val(res.booking.forward_method_payment);

                    if(res.bookingStatus.name !== '{{ \App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED }}'){
                        $("#bookingEditModal form input[name='cost[forward]").prop('readonly', true);
                        $("#bookingEditModal form select[name='booking[forward_method_payment]").prop('readonly', true);
                        $("#bookingEditModal form select[name='booking[forward_method_payment]").attr('readonly', 'readonly');
                    }



                    $("#bookingEditModal form input[name='cost[total_pay]").val(res.booking.cost);
                    $("#bookingEditModal form textarea[name='booking[comments]").text(res.booking.comments);

                    $("#eRoomPrice").val(res.roomType.price);

                    optionsBv = "";
                    $.each(res.bookingStatusValid, function(key, value){
                        optionsBv += "<option value='"+key+"'>"+value+"</option>";
                    });
                    $("#bookingEditModal form select[name='booking[status]']").empty().append(optionsBv);

                    if(!res.activeEdit){
                        $("#bookingEditModal form .modal-footer button[value='update']").attr('disabled', 'disabled');
                        $("#bookingEditModal form .modal-footer button[value='delete']").attr('disabled', 'disabled');
                    } else {
                        $("#bookingEditModal form .modal-footer button[value='update']").removeAttr('disabled');
                        $("#bookingEditModal form .modal-footer button[value='delete']").removeAttr('disabled');
                    }

                    $('#bookingEditModal').modal('show');
                },
                error: function (data) {
                }
            });
        }

        function clearEditErrorInputs(){
            $("#bookingEditModal form input, select, textarea").removeClass('is-invalid');
        }

        function calculateCostEdit(){
            // const checkinD = moment YYYY-MM-DDThh:mm
            const checkinD = moment($("#bookingEditModal form input[name='booking[checkin_date]']").val(), 'YYYY-MM-DDThh:mm');
            const checkoutD = moment($("#bookingEditModal form input[name='booking[checkout_date]']").val(), 'YYYY-MM-DDThh:mm');
            const reservationDays = Math.ceil(checkoutD.diff(checkinD, "days", true));
            // Math.ceil(d)
            $("#e-display-reservation-day").empty().text("(Precio hab: " + $("#eRoomPrice").val() + " | Dias: " + reservationDays + ")");

            let discountType = parseInt($("#bookingEditModal form input[name='cost[discount_type]']:radio:checked").val());
            let discount = $("#e-cost-discount").val()? parseFloat($("#e-cost-discount").val()) : 0;
            let cCostExtraCharge = $("#e-cost-extra_charge").val()? parseFloat($("#e-cost-extra_charge").val()) : 0;
            let cCostForward = $("#e-cost-forward").val()? parseFloat($("#e-cost-forward").val()) : 0;
            let costTotal = $("#eRoomPrice").val()? parseFloat($("#eRoomPrice").val()) : 0;
            let total = 0;
            if(discountType === 1){
                if(discount === 0){
                    total = (costTotal * reservationDays) + cCostExtraCharge - cCostForward;
                } else {
                    total = ((costTotal * reservationDays) - ((costTotal * reservationDays) * discount / 100)) + cCostExtraCharge - cCostForward;
                }
            } else {
                total = (costTotal * reservationDays) + cCostExtraCharge - cCostForward - discount;
            }
            $("#e-cost-total_pay").val(total.toFixed(2));
        }

        function showMethodPayment(select){
            calculateCostEdit();
            const forward = $(select).val();
            console.log("eww: ", forward);
            if(forward && parseInt(forward) > 0){
                $("#eGroupForwardMethodPayment").show();
            } else {
                $("#eGroupForwardMethodPayment").hide();
            }
        }

        function updateBookingModal(form){
            $.ajax({
                url:"{{route('customer.booking.a_update')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#bookingEditModal").modal('hide');
                    showAlert(res.message.typeIcon, res.message.title);
                    if(eventCalendar !== null){
                        eventCalendar.refetchEvents();
                    }
                },
                error: function (data) {
                    const errors = data.responseJSON.errors;
                    $.each(errors, function (key, values) {
                        const propertyId = '#e-' + key.replaceAll('.', '-');
                        let errorLis = "<ul style='padding-left: 4px;'>";
                        console.log("Editar errores:: ", propertyId);
                        $.each(values, function(k, value){
                            errorLis += "<li>"+value+"</li>";
                        });
                        errorLis += "</ul>";
                        $(propertyId).addClass('is-invalid');
                        $(propertyId+"-feedback").empty().append(errorLis);

                    });
                }
            });
        }

        function aBookingDelete(){
            const bookingId = $("#bookingEditModal form input[name='booking[id]']").val();
            if (confirm("Confirme su decision de eliminar la reserva") == true) {
                $.ajax({
                    url:"{{route('customer.booking.a_delete')}}",
                    type: 'post',
                    data : {"_token": "{{ csrf_token() }}", bookingId},
                    dataType:'json',
                    beforeSend:function(){
                    },
                    success:function(res){
                        $("#bookingEditModal").modal('hide');
                        showAlert(res.message.typeIcon, res.message.title);
                        if(eventCalendar !== null){
                            eventCalendar.refetchEvents();
                        }
                    },
                    error: function (data) {
                    }
                });
            }

        }
    </script>

@endpush
