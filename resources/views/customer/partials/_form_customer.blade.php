@csrf
<div class="form-group">
    <label for="c-customer-person-first_name">
        Nombres <span class="text-danger">*</span>
    </label>
    <input type="text" class="form-control form-control-sm" id="c-customer-person-first_name"
           name="customer[person][first_name]">
    <div class="invalid-feedback"></div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-customer-person-last_name_paternal">Apellido paterno <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" id="c-customer-person-last_name_paternal"
               name="customer[person][last_name_paternal]">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-6 form-group">
        <label for="c-customer-person-last_name_maternal">Apellido materno</label>
        <input type="text" class="form-control form-control-sm" id="c-customer-person-last_name_maternal"
               name="customer[person][last_name_maternal]">
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-customer-person-document_type">Tipo de documento <span class="text-danger">*</span></label>
        <select class="form-control form-control-sm" id="c-customer-person-document_type" name="customer[person][document_type]">
            <option value="">Seleccione</option>
            @foreach($documentTypes as $documentType)
                <option value="{{$documentType}}">{{$documentType}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-4 form-group">
        <label for="c-customer-person-document">Documento <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" id="c-customer-person-document" name="customer[person][document]">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-2 form-group">
        <label for="c-customer-person-document_complement">Cmpl</label>
        <input type="text" class="form-control form-control-sm" id="c-customer-person-document_complement" name="customer[person][document_complement]">
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-customer-nit">NIT</label>
        <input type="text" class="form-control form-control-sm" id="c-customer-nit" name="customer[nit]">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-6 form-group">
        <label for="c-customer-nit_name">Nombre factura</label>
        <input type="text" class="form-control form-control-sm" id="c-customer-nit_name" name="customer[nit_name]">
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="c-customer-email">Correo</label>
        <input type="email" class="form-control form-control-sm" id="c-customer-email" name="customer[email]">
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-6 form-group">
        <label for="c-customer-phone">Telefono</label>
        <input type="text" class="form-control form-control-sm" id="c-customer-phone" name="customer[phone]">
        <div class="invalid-feedback"></div>
    </div>
</div>
