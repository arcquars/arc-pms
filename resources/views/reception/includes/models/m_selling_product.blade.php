<!-- Modal Selling Product -->
<div class="modal modal-arc fade" id="sellingProductsModal" data-backdrop="static" data-keyboard="false" aria-labelledby="sellingProductsModalLabel" aria-hidden="true">
    <form onsubmit="saveReceipt(this); return false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sellingProductsModalLabel">Proceso de venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer d-flex bd-highlight">
                    <button type="button" class="btn btn-secondary btn-sm mr-auto bd-highlight" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary btn-sm bd-highlight" type="submit">Registrar venta</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/template" id="template_tr_product">
    <tr data-price="<%= product.price_reference %>">
        <td><%= product.name %></td>
        <td><%= product.measure %></td>
        <td>
            <input type="number" name="products[<%= index %>][amount]" min="1" step="1" value="1" class="form-control form-control-sm-arc p-amount" onchange="trUpdateSaleProduct(this)">
            <input type="hidden" name="products[<%= index %>][product_id]" value="<%= product.id %>">
            <input type="hidden" name="products[<%= index %>][price_reference]" value="<%= product.price_reference %>">
            <input type="hidden" name="products[<%= index %>][price_minimum]" value="<%= product.price_minimum %>">
        </td>
        <td class="text-right">
            <input type="number" name="products[<%= index %>][price]" min="1" step="0.1" value="<%= product.price_reference %>" class="form-control form-control-sm-arc p-price" onchange="trUpdateSaleProduct(this)">
        </td>
        <td class="text-right td-total"><%= product.price_reference %></td>
        <td class="text-right">
            <a href="#" class="btn btn-link btn-sm text-danger" onclick="removeTrProduct(this); return false;"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>
</script>
<script type="text/template" id="template-ul-errors">
    <% if (typeof (errors) != "undefined") {%>
    <ul class="list-unstyled">
        <% _.each(errors, function(error) { %>
            <% _.each(error, function(item) { %>
            <li><p class="mb-0 pb-0 ml-2"><small class="text-danger text-small"><%= item %></small></p></li>
            <% }); %>
        <% }); %>
    </ul>
    <% } %>
</script>
@push('js')
    <script>
        let productCount = 0;
        $( document ).ready(function() {
        });

        function openSellingProductsModal(bookingId){
            productCount = 0;
            $.ajax({
                url:"{{route('admin.booking.fSellingProducts')}}",
                type: 'post',
                data : {
                    "_token": "{{ csrf_token() }}",
                    bookingId},
                dataType:'json',
                beforeSend:function(){
                },
                success:function(res){
                    $("#sellingProductsModal .modal-body").empty().append(res.view);
                    $("#sellingProductsModal").modal("show");
                },
                error: function (data) {
                }

            });
        }

        function addProductTable(select){
            if(!select.val()){
                alert("Seleccione un producto");
            } else {
                productCount++;
                $.ajax({
                    url:"{{route('admin.product.aGetProduct')}}",
                    type: 'post',
                    data : {
                        "_token": "{{ csrf_token() }}",
                        'productId': select.val()},
                    dataType:'json',
                    beforeSend:function(){
                    },
                    success:function(res){
                        // alert(JSON.stringify(res.product));
                        const templateCBookingStatus = _.template($("#template_tr_product").html());
                        $("#sellingProductsModal .modal-body table tbody").append(templateCBookingStatus({product: res.product, index: productCount
                        }));
                        calTotalSale();
                    },
                    error: function (data) {
                    }

                });
            }
        }

        function removeTrProduct(link){
            $(link).parent().parent().remove();
            calTotalSale();
        }

        function trUpdateSaleProduct(input){
            let amount = parseInt($(input).val());
            if(amount > 0){

            } else {
                alert('La cantidad tiene que ser mayor a cero.');
                amount = 1;
                $(input).val("1");
            }
            calTotalSale();
        }
        function calTotalSale(){
            const trs = $("#sellingProductsModal .modal-body table tbody tr");
            let totalAll = 0;
            $.each(trs, function(index, tr){
                // const price = $(tr).attr('data-price');
                const price = $(tr).find('.p-price').val();
                const amount = $(tr).find('.p-amount').val();
                const total = price * amount;
                totalAll += total;
                $(tr).find(".td-total").empty().text(total);
                console.log("eee:", price + " || " + amount);
            });
            $(".total-all").empty().text(totalAll);
        }

        function showPaymentType(radio){
            if($(radio).is(':checked') && $(radio).val() === 'now'){
                $("#sellingProductsModal .d-payment-type").css('display', 'block');
            } else {
                $("#sellingProductsModal .d-payment-type").css('display', 'none');
            }
        }

        function saveReceipt(form){
            $("#sellingProductsModal .modal-body .errors").empty();
            $.ajax({
                url:"{{route('admin.booking.saveSellingProducts')}}",
                type: 'post',
                data : $(form).serialize(),
                dataType:'json',
                beforeSend:function(){
                    enableBtnSubmit(false);
                },
                success:function(res){
                    showAlert(res.message.typeIcon, res.message.title);
                    $("#sellingProductsModal").modal('hide');
                },
                complete: function(){
                    enableBtnSubmit(true);
                },
                error: function (data) {
                    if(data && data.responseJSON.message.typeIcon){
                        showAlert(data.responseJSON.message.typeIcon, data.responseJSON.message.title);
                    } else {
                        const errors = data.responseJSON.errors;
                        const templateSellingErrors = _.template($("#template-ul-errors").html());
                        $("#sellingProductsModal .modal-body .errors").empty().append(templateSellingErrors({errors}));
                    }
                }

            });
        }

        function enableBtnSubmit(enable){
            if(enable){
                $("#sellingProductsModal form button[type='submit']").prop('disabled', false);
            } else {
                $("#sellingProductsModal form button[type='submit']").prop('disabled', true);
            }
        }
    </script>

@endpush
