<!-- Modal delete Image of product -->
<div class="modal fade" id="productImageDeleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="productImageDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form onsubmit="removeProductImage(this); return false;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productImageDeleteModalLabel">Eliminar imagen del producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="productId">
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">Esta seguro de eliminar la imagen?</p>
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

        function openProductImageDeleteModal(productId){
            $('#productImageDeleteModal form input[name="productId"]').val(productId);
            $('#productImageDeleteModal').modal('show');
        }

        function removeProductImage(form){
            $.ajax({
                url:"{{route('admin.product.adeletefilename')}}",
                {{--url:"{{route('admin.product.aDeleteFilename')}}",--}}
                type: 'post',
                dataType:'json',
                data: $(form).serialize(),
                beforeSend:function(){
                },
                success:function(res){
                    $("#productImageDeleteModal").modal('hide');
                },
                error: function (data) {
                }

            });
        }

    </script>

@endpush
