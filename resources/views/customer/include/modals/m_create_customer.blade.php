<!-- Modal create Customer -->
<div class="modal fade" id="customerCreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="customerCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="saveCustomer(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerCreateModalLabel">Crear Cliente</h5>
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

        function openCustomerCreateModal(){
            $.ajax({
                url:"{{route('admin.customer.aGetFormCustomer')}}",
                type: 'get',
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $('#customerCreateModal').modal('show');
                    $("#customerCreateModal .modal-body").empty().append(res.view);
                },
                error: function (data) {
                }
            });
        }

        function saveCustomer(form){
            clearErrorInputs();
            $.ajax({
                url:"{{route('admin.customer.aSaveCustomer')}}",
                type: 'post',
                data: $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $('#customerCreateModal').modal('hide');
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

        function clearErrorInputs(){
            $("#customerCreateModal form input, select, textarea").removeClass('is-invalid');
            $("#customerCreateModal form input, select, textarea").next('.invalid-feedback').empty();
            // $("#bookingCreateModal form input").next().empty();
        }
    </script>

@endpush
