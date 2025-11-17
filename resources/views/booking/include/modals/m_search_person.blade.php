<!-- Modal search person -->
<div class="modal fade" id="searchPersonModal" data-backdrop="static" data-keyboard="false" aria-labelledby="searchPersonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchPersonModalLabel">Buscar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="searchPersonSelect">Cliente:</label>
                    <select id="searchPersonSelect" class="js-search-person form-control form-control-sm" name="state"></select>
                </div>

            </div>
            <div class="modal-footer d-flex bd-highlight">
                <button type="button" class="btn btn-secondary btn-sm mr-auto p-2 bd-highlight" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary btn-sm p-2 bd-highlight" type="button" onclick="aLoadCustomer();">Cargar</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $( document ).ready(function() {
            $('#searchPersonModal').on('shown.bs.modal', function () {
                $('.js-search-person').select2({
                    ajax: {
                        url: "{{route('customer.ajax-search-person')}}",
                        type: "POST",
                        dataType: 'json',
                        delay: 400,
                        data : function (params) {
                            return {
                                "_token": "{{ csrf_token() }}",
                                q: $.trim(params.term)
                            }

                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(categoria) {
                                    return { id: categoria.id, text: categoria.text };
                                })
                            };
                        }
                    }
                });
                $('.js-search-person').val(null).trigger('change');
            });
        });

        function openSearchPersonModal(){
            $("#searchPersonModal").modal("show");
        }

        function aLoadCustomer(){
            const customer = $("#searchPersonSelect").val();
            $.ajax({
                url:"{{route('admin.customer.a_get_customer')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    customer},
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    if(typeof loadCustomerById === 'function'){
                        loadCustomerById(res.customer, res.person);
                    }
                    $("#searchPersonModal").modal("hide");
                },
                error: function (data) {
                }

            });
        }
    </script>

@endpush
