<!-- Modal Close Room cleaning -->
<div class="modal fade" id="roomStatusCloseModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="roomStatusCloseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="saveCloseRoomStatus(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomStatusCloseModalLabel">Cerrar <span class="room-status-name"></span> de habitacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="h-room-name text-center text-primary"></h4>
                    @csrf
                    <input type="hidden" name="room_status_id" value="">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="mcrsUserId">Usuario</label>
                            <select id="mcrsUserId" name="assigned_to" class="form-control form-control-sm">
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="mcrsCloseDate">Fecha / hora</label>
                            <input id="mcrsCloseDate" type="datetime-local" name="action_date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <ul class="ul-errors"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-warning btn-sm" type="submit" >
                        Cerrar
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

        function openRoomStatusCloseModal(roomStatusId){
            $.ajax({
                url:"{{route('admin.room-status.a_get_room_status')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    roomStatusId,
                },
                dataType:'json',
                success:function(res){

                    $("#roomStatusCloseModal form .room-status-name").empty().text(translateStatus(res.roomStatus.name));
                    $("#roomStatusCloseModal form .h-room-name").empty().text(res.room.title);
                    let options = "<option value=''>Seleccione...</option>";
                    $.each(res.users, function(key, value){
                        options += "<option value='"+key+"'>"+value+"</option>";
                    });
                    $("#roomStatusCloseModal form select[name='assigned_to']").empty().append(options);
                    $("#roomStatusCloseModal form input[name='action_date']").val(res.now);
                    $("#roomStatusCloseModal form input[name='room_status_id']").val(res.roomStatus.id);
                    $('#roomStatusCloseModal').modal('show');
                },
                error: function (data) {

                }
            });
        }

        function translateStatus(name){
            let result = "";
            switch (name) {
                case '{{ \App\Models\RoomStatus::STATUS_CLEANING }}':
                    result = "{{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_CLEANING) }}";
                    break;
                case '{{ \App\Models\RoomStatus::STATUS_MAINTENANCE }}':
                    result = "{{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_MAINTENANCE) }}";
                    break;
                case '{{ \App\Models\RoomStatus::STATUS_BLOOKED }}':
                    result = "{{ __('hotel-manager.'.\App\Models\RoomStatus::STATUS_BLOOKED) }}";
                    break;
            }
            return result;
        }

        function saveCloseRoomStatus(form){
            $('#roomStatusCloseModal form .ul-errors').empty();
            $.ajax({
                url:"{{route('admin.room-status.a_close_room_status')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                success:function(res){
                    $("#roomStatusCloseModal").modal('hide');
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
                        $('#roomStatusCloseModal form .ul-errors').empty().append(errorLis);
                    }

                }
            });
        }
    </script>

@endpush
