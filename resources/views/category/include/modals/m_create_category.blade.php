<!-- Modal create booking -->
<div class="modal fade" id="categoryCreateModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="categoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="saveCategory(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryCreateModalLabel">Nueva categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="c-name">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="c-name" placeholder="">
                        <div class="invalid-feedback"></div>
                    </div>
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

        function openCategoryCreateModal(){
            clearErrorInputs();
            $('#categoryCreateModal').modal('show');
        }

        function saveCategory(form){
            $.ajax({
                url:"{{route('category.store')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#categoryCreateModal").modal('hide');
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
                        $(propertyId).addClass('is-invalid');
                        $(propertyId).next().empty().append(errorLis);

                    });
                }

            });
        }

        function clearErrorInputs(){
            $("#categoryCreateModal form input[name='name']").val('');
            $("#categoryCreateModal form input[name='name']").removeClass('is-invalid');
            $("#categoryCreateModal form input[name='name']").next('.invalid-feedback').empty();
            // $("#bookingCreateModal form input").next().empty();
        }
    </script>

@endpush
