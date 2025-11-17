<!-- Modal delete booking -->
<div class="modal fade" id="categoryDeleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="categoryDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="removeCategory(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryDeleteModalLabel">Eliminar categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="categoryId">
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">Esta seguro de eliminar <b class="mc-name"></b>?</p>
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

        function openCategoryDeleteModal(categoryId){
            $.ajax({
                url:"{{url('admin/product/get-category')}}/" + categoryId,
                type: 'get',
                // dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    // alert("fff 8:: " + res.category.name);
                    $('#categoryDeleteModal .mc-name').text(res.category.name);
                    $('#categoryDeleteModal form input[name="categoryId"]').val(res.category.id);
                    $('#categoryDeleteModal').modal('show');
                }
            });
        }

        function removeCategory(form){
            const categoryId = $(form).find("input[name='categoryId']").val();
            $.ajax({
                url:"{{url('admin/product/category')}}/" + categoryId,
                type: 'delete',
                dataType:'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend:function(){
                },
                success:function(res){
                    $("#categoryDeleteModal").modal('hide');
                    location.reload();
                },
                error: function (data) {
                }

            });
        }

    </script>

@endpush
