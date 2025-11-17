<?php
$customerId = old('customerId');
$customerName = "";
if($customerId){
    $customerName = \App\Models\Customer::find($customerId)->full_name_nit;
}
?>
<h5>Datos del Cliente</h5>
<hr>
<div class="form-group">
    <label for="" style="width: 100%;">
        Nombres
        <a href="#" class="btn btn-primary btn-sm float-right" onclick="openCustomerCreateModal(); return false;">
            <i class="fas fa-user-plus"></i>
        </a>
    </label>
    <select id="searchPersonSelect" class="js-search-person form-control form-control-sm @error('customerId') is-invalid @enderror" name="customerId">
    </select>

{{--    <input type="hidden" id="customer-id" name="customerId" class="@error('customerId') is-invalid @enderror">--}}
    @error('customerId')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="">Tipo Documento</label>
        <input type="text" id="customer-client-document_type"
               class="form-control form-control-sm customer-class disabled" disabled>
    </div>
    <div class="col-md-6 form-group">
        <label for="">Documento</label>
        <input type="text" id="customer-client-document" class="form-control form-control-sm customer-class disabled" disabled>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="">NIT</label>
        <input type="text" id="customer-nit" class="form-control form-control-sm customer-class disabled" disabled>
    </div>
    <div class="col-md-6 form-group">
        <label for="">Nombre a Facturar</label>
        <input type="text" id="customer-nit_name" class="form-control form-control-sm customer-class disabled" disabled>
    </div>
</div>
<div class="row">
    <div class="col-md-8 form-group">
        <label for="">Correo</label>
        <input type="text" id="customer-email" class="form-control form-control-sm customer-class disabled" disabled>
    </div>
    <div class="col-md-4 form-group">
        <label for="">Telefono</label>
        <input type="text" id="customer-phone" class="form-control form-control-sm customer-class disabled" disabled>
    </div>
</div>
<div class="form-check form-check-inline">
    <input class="form-check-input" type="checkbox" id="c-send_email" name="customer[send_email]" value="1">
    <label class="form-check-label" for="c-send_email">Enviar estado de cuenta por correo</label>
</div>
@prepend('js')
    <script>
        $(document).ready(function(){
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

            $('.js-search-person').on('select2:select', function (e) {
                var selectedData = e.params.data;
                console.log('ID seleccionado:', selectedData.id);
                console.log('Texto seleccionado:', selectedData.text);

                aLoadCustomer(selectedData.id);

            });

            let customerId = "{{ old('customerId') }}";

            if (customerId) {
                const customerSelect = $('.js-search-person');
                const customerName = "{{$customerName}}";
                const option = new Option(customerName, customerId, true, true);
                customerSelect.append(option).trigger('change');

                // manually trigger the `select2:select` event
                customerSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: {id: customerId, text: customerName}
                    }
                });
            }

            $(".customer-class").val("");
            $("#customer-id").val("");

        });

        function aLoadCustomer(customer){
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
                    console.log("Res::", JSON.stringify(res));
                    console.log("Res::", res.person.document_type);
                    $("#customer-client-document_type").val(res.person.document_type);
                    $("#customer-client-document").val(res.person.document);
                    $("#customer-id").val(res.customer.id);
                    $("#customer-nit").val(res.customer.nit);
                    $("#customer-nit_name").val(res.customer.nit_name);
                    $("#customer-email").val(res.customer.email);
                    $("#customer-phone").val(res.customer.mobile);
                },
                error: function (data) {
                }

            });
        }

    </script>
@endprepend
