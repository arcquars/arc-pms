<!-- Modal edit factory -->
<div class="modal fade" id="factoryEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="factoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="updateFactory(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="factoryEditModalLabel">Editar fabrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary btn-sm" type="submit" >
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

        function openFactoryEditModal(factoryId){
            $.ajax({
                url:"{{url('admin/product/factory/a-get-factory')}}/" + factoryId,
                type: 'get',
                beforeSend:function(){
                },
                success:function(res){
                    $('#factoryEditModal .modal-body').empty().append(res.html);
                    $('#factoryEditModal').modal('show');
                }
            });
        }

        function updateFactory(form){
            $.ajax({
                url:"{{route('admin.product.factory.aUpdateFactory')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#factoryEditModal").modal('hide');
                    // showAlert(res.message.typeIcon, res.message.title);
                    location.reload();
                },
                error: function (data) {
                    const errors = data.responseJSON.errors;
                    $.each(errors, function (key, values) {
                        const propertyId = '#f-' + key;
                        let errorLis = "<ul style='padding-left: 4px;'>";
                        $.each(values, function(k, value){
                            errorLis += "<li>"+value+"</li>";
                        });
                        errorLis += "</ul>";
                        $(form).find(propertyId).addClass('is-invalid');
                        $(form).find(propertyId).next().empty().append(errorLis);

                    });
                }

            });
        }

        function clearErrorInputsEdit(){
            $("#factoryEditModal form input[name='name']").val('');
            $("#factoryEditModal form input[name='name']").removeClass('is-invalid');
            $("#factoryEditModal form input[name='name']").next('.invalid-feedback').empty();
            // $("#bookingCreateModal form input").next().empty();
        }
    </script>

@endpush
