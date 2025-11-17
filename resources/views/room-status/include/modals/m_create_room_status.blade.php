<!-- Modal create Room cleaning -->
<div class="modal fade" id="roomStatusCreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="roomStatusCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="saveRoomStatus(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomStatusCreateModalLabel">Registrar <span class="room-status-name"></span> de habitacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="h-room-name text-center text-primary"></h4>
                    @csrf
                    <input type="hidden" name="roomId" value="">
                    <input type="hidden" name="room-status-name" value="">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Fecha / hora Inicio</label>
                            <input type="datetime-local" name="start_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Fecha / hora Fin</label>
                            <input type="datetime-local" name="end_date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <ul class="ul-errors"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary btn-sm" type="submit" >
                        Crear
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

        function openRoomStatusCreateModal(roomId, bookingId, status){
            let sRoomStatusName = "{{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_MAINTENANCE) }}";
            if(status === '{{\App\Models\RoomStatus::STATUS_CLEANING}}'){
                sRoomStatusName = "{{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_CLEANING) }}";
            }
            $.ajax({
                url:"{{route('admin.room.get_room_status')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    roomId,
                    bookingId,
                    status
                },
                dataType:'json',
                success:function(res){
                    $('#roomStatusCreateModal .room-status-name').empty().text(sRoomStatusName);
                    $('#roomStatusCreateModal .h-room-name').empty().text(res.room.title);
                    $('#roomStatusCreateModal form input[name="start_date"]').val(res.startDate);
                    $('#roomStatusCreateModal form input[name="end_date"]').val(res.endDate);
                    $('#roomStatusCreateModal form input[name="room-status-name"]').val(status);
                    $('#roomStatusCreateModal form input[name="roomId"]').val(res.room.id);

                    $('#roomStatusCreateModal form .ul-errors').empty();
                    $('#roomStatusCreateModal').modal('show');
                },
                error: function (data) {

                }
            });
        }

        function saveRoomStatus(form){
            $('#roomStatusCreateModal form .ul-errors').empty();
            $.ajax({
                url:"{{route('admin.room-status.a_save_room_status')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                success:function(res){
                    $("#roomStatusCreateModal").modal('hide');
                    showAlert(res.message.typeIcon, res.message.title);
                    if(typeof reloadTab === 'function'){
                        reloadTab();
                    }
                },
                error: function (data) {
                    if(data.responseJSON.result !== undefined){
                        showAlert(data.responseJSON.message.typeIcon, data.responseJSON.message.title);
                    } else {
                        const errors = data.responseJSON.errors;
                        let errorLis = "";
                        $.each(errors, function (key, values) {
                            $.each(values, function(k, value){
                                errorLis += "<li class='text-small text-danger'>"+value+"</li>";
                            });
                        });
                        $('#roomStatusCreateModal form .ul-errors').empty().append(errorLis);
                    }

                }
            });
        }
    </script>

@endpush
