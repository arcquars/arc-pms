<!-- Modal create booking status -->
<div class="modal modal-arc fade" id="bookingStatusCreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="bookingStatusCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="saveBookingState(this); return false;">
            <div class="modal-content">
                <div class="modal-header pt-2 pb-2">
                    <h5 class="modal-title" id="bookingStatusCreateModalLabel">Registrar Estado de reserva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer pt-2 pb-2">
                    <button type="button" class="btn btn-secondary btn-sm mr-auto bd-highlight" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary btn-sm bd-highlight" type="submit" >
                        Grabar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js')
    <script>
        $( document ).ready(function() {
        });

        function openCreateBookingStatusModal(bookingId, bookingStatus){
            $.ajax({
                url:"{{route('admin.booking.a_get_booking_modal')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    booking_id: bookingId,
                    bookingStatus
                },
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    // const templateCBookingStatus = _.template($("#template_c_booking_status").html());
                    // $("#bookingStatusCreateModal .modal-body").empty().append(templateCBookingStatus({
                    //     room: res.room, person: res.person, booking: res.booking, bookingStatus: res.bookingStatus,
                    //     now: res.now, status: bookingStatus
                    // }));
                    $("#bookingStatusCreateModal .modal-body").empty().append(res.html);
                    $("#bookingStatusCreateModal").modal("show");
                },
                error: function (data) {
                }

            });
        }

        function translateBokingStatusName(bookingStatusName){
            let transText = "";
            switch (bookingStatusName) {
                case '{{ \App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED }}':
                    transText = "{{ __('hotel-manager.'.\App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED) }}";
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_RESERVATION_CONFIRMED }}':
                    transText = "{{ __('hotel-manager.'.\App\Models\BookingStatus::STATUS_RESERVATION_CONFIRMED) }}";
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_INCOME }}':
                    transText = "{{ __('hotel-manager.'.\App\Models\BookingStatus::STATUS_INCOME) }}";
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_NO_INCOME }}':
                    transText = "{{ __('hotel-manager.'.\App\Models\BookingStatus::STATUS_NO_INCOME) }}";
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_HOSTING_COMPLETED }}':
                    transText = "{{ __('hotel-manager.'.\App\Models\BookingStatus::STATUS_HOSTING_COMPLETED) }}";
                    break;
                default:
                    transText = "--";
            }

            return transText;
        }

        function calculateCost(){
            calculateCostBySectionId("bookingStatusCreateModal");
        }

        function showTypeDiscount(radio){
            showTypeDiscountBySectionId("bookingStatusCreateModal", parseInt($(radio).val()));
            calculateCost();
        }

        function saveBookingState(form){
            clearErrorInputs("bookingStatusCreateModal");
            $.ajax({
                url: getUrlUpdateBookingState($(form).find('input[name="booking_status_name"]').val(), $(form).find('input[name="booking_status_next"]').val()),
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#bookingStatusCreateModal").modal('hide');
                    if(typeof reloadTab === 'function'){
                        reloadTab();
                    }
                    showAlert(res.message.typeIcon, res.message.title);

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
        }

        function getUrlUpdateBookingState(bookingState, bookingStateNext){
            let url = '';
            switch (bookingState) {
                case '{{ \App\Models\BookingStatus::STATUS_RESERVATION_CONFIRMED }}':
                    url = "{{route('admin.booking.a_update_booking_state_confirmed')}}";
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED }}':
                    if(bookingStateNext === '{{ \App\Models\BookingStatus::STATUS_NO_INCOME }}'){
                        url = "{{route('admin.booking.a_update_booking_state_not_income')}}";
                    } else {
                        url = "{{route('admin.booking.a_update_booking_state_not_confirmed')}}";
                    }
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_NO_INCOME }}':
                    url = "{{route('admin.booking.a_update_booking_state_not_income')}}";
                    break;
                case '{{ \App\Models\BookingStatus::STATUS_INCOME }}':
                    url = "{{route('admin.booking.a_update_booking_state_income')}}";
                    break;
                default:
                    url = "";
                    break;
            }
            return url;
        }
    </script>

@endpush
