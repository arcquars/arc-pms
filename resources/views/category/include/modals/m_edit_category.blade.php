<!-- Modal create booking -->
<div class="modal fade" id="categoryEditModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="updateCategory(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditModalLabel">Editar categoria</h5>
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

        function openCategoryEditModal(categoryId){
            $.ajax({
                url:"{{url('admin/product/a-get-category/')}}/" + categoryId,
                type: 'get',
                beforeSend:function(){
                },
                success:function(res){
                    $('#categoryEditModal .modal-body').empty().append(res.html);
                    $('#categoryEditModal').modal('show');
                }
            });
        }

        function updateCategory(form){
            $.ajax({
                url:"{{route('admin.product.category.aUpdateCategory')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#categoryEditModal").modal('hide');
                    // showAlert(res.message.typeIcon, res.message.title);
                    location.reload();
                },
                error: function (data) {
                    const errors = data.responseJSON.errors;
                    $.each(errors, function (key, values) {
                        const propertyId = '#c-' + key;
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
            $("#categoryEditModal form input[name='name']").val('');
            $("#categoryEditModal form input[name='name']").removeClass('is-invalid');
            $("#categoryEditModal form input[name='name']").next('.invalid-feedback').empty();
            // $("#bookingCreateModal form input").next().empty();
        }
    </script>

@endpush
