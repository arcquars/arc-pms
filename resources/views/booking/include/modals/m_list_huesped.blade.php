<!-- Modal search person -->
<div class="modal fade" id="listHuespedModal" data-backdrop="static" data-keyboard="false" aria-labelledby="listHuespedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listHuespedModalLabel">Lista de huespedes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer d-flex bd-highlight">
                <button type="button" class="btn btn-secondary btn-sm mr-auto p-2 bd-highlight" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $( document ).ready(function() {
        });

        function openlistHuespedModal(bookingId){
            $.ajax({
                url:"{{route('admin.booking.a_get_list_huesped')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    booking_id: bookingId},
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#listHuespedModal").modal("show");
                    $("#listHuespedModal .modal-body").empty().append(res.html);
                },
                error: function (data) {
                }
            });
        }

        function saveHuesped(form){
            $.ajax({
                url:"{{route('admin.huesped.asave')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    if(res.success){
                        $("#listHuespedModal .modal-body").empty().append(res.html);
                    } else {
                        alert("Ya registro todos los huespedes");
                    }
                },
                error: function (data) {
                }
            });
        }

        function deleteHuesped(huespedId){
            $.ajax({
                url:"{{route('admin.huesped.adelete')}}",
                type: 'post',
                    data : {
                        "_token": "{{ csrf_token() }}",
                        huesped_id: huespedId},
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#listHuespedModal .modal-body").empty().append(res.html);
                },
                error: function (data) {
                }
            });
        }

    </script>

@endpush
