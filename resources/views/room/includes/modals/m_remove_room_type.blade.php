<!-- Modal search person -->
<div class="modal modal-arc fade" id="removeRoomTypeModal" data-backdrop="static" data-keyboard="false" aria-labelledby="removeRoomTypeModalLabel" aria-hidden="true">
    <form onsubmit="deleteRoomType(this); return false;" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeRoomTypeModalLabel">Eliminar tipo de habitación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer d-flex bd-highlight">
                    <button type="button" class="btn btn-secondary btn-sm mr-auto bd-highlight" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger btn-sm bd-highlight" type="submit">Eliminar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
        $( document ).ready(function() {

        });

        function openRemoveRoomTypeModal(roomTypeId){
            $("#removeRoomTypeModal .text-danger").empty().append("");
            $.ajax({
                url:"{{url('admin/a-get-room-type/')}}/" + roomTypeId,
                type: 'get',
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#removeRoomTypeModal .modal-body").empty().append(res.html);
                    $("#removeRoomTypeModal").modal("show");
                },
                error: function (data) {
                }

            });
        }

        function deleteRoomType(form){
            $.ajax({
                url:"{{route('admin.room_type.a_delete_room_type')}}",
                type: 'post',
                data: $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    location.reload();
                    // $("#removeRoomTypeModal").modal("hide");
                },
                error: function (data) {
                    $(form).find(".text-danger").empty().append(data.responseJSON.error);
                }
            });
        }

    </script>

@endpush
