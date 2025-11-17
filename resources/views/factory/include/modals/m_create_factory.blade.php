<!-- Modal create booking -->
<div class="modal fade" id="factoryCreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="factoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="saveFactory(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="factoryCreateModalLabel">Nueva fabrica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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

        function openFactoryCreateModal(){
            $.ajax({
                url:"{{url('admin/product/factory/a-get-factory/')}}",
                type: 'get',
                beforeSend:function(){
                },
                success:function(res){
                    $('#factoryCreateModal .modal-body').empty().append(res.html);
                    $('#factoryCreateModal').modal('show');
                }
            });
        }

        function saveFactory(form){
            $.ajax({
                url:"{{route('factory.store')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#factoryCreateModal").modal('hide');
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
                        $(propertyId).addClass('is-invalid');
                        $(propertyId).next().empty().append(errorLis);

                    });
                }

            });
        }

        function clearErrorInputs(){
            $("#factoryCreateModal form input[name='name']").val('');
            $("#factoryCreateModal form input[name='name']").removeClass('is-invalid');
            $("#factoryCreateModal form input[name='name']").next('.invalid-feedback').empty();
            // $("#bookingCreateModal form input").next().empty();
        }
    </script>

@endpush
