<!-- Modal delete Factory -->
<div class="modal fade" id="factoryDeleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="factoryDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="removeFactory(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="factoryDeleteModalLabel">Eliminar Fabrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="factoryId">
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">Esta seguro de eliminar <b class="mf-name"></b>?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger btn-sm" type="submit" >
                        Eliminar
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

        function openFactoryDeleteModal(factoryId){
            $.ajax({
                url:"{{url('admin/product/factory/get-factory')}}/" + factoryId,
                type: 'get',
                // dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    // alert("fff 8:: " + res.category.name);
                    $('#factoryDeleteModal .mf-name').text(res.factory.name);
                    $('#factoryDeleteModal form input[name="factoryId"]').val(res.factory.id);
                    $('#factoryDeleteModal').modal('show');
                }
            });
        }

        function removeFactory(form){
            const categoryId = $(form).find("input[name='factoryId']").val();
            $.ajax({
                url:"{{url('admin/product/factory')}}/" + categoryId,
                type: 'delete',
                dataType:'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend:function(){
                },
                success:function(res){
                    $("#factoryDeleteModal").modal('hide');
                    location.reload();
                },
                error: function (data) {
                }

            });
        }

    </script>

@endpush
