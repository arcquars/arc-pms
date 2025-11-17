@csrf
<input type="hidden" name="factory" value="@if($factory) {{$factory->id}} @endif">
<div class="form-group">
    <label for="f-name">Nombre <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" id="f-name" placeholder="" value="@if($factory) {{$factory->name}} @endif">
    <div class="invalid-feedback"></div>
</div>
<div class="form-group">
    <label for="f-contact">Persona de Contacto</label>
    <input type="text" name="contact" class="form-control" id="f-contact" placeholder="" value="@if($factory) {{$factory->contact}} @endif">
    <div class="invalid-feedback"></div>
</div>
<div class="form-group">
    <label for="f-origin">Origen</label>
    <input type="text" name="origin" class="form-control" id="f-origin" placeholder="" value="@if($factory) {{$factory->origin}} @endif">
    <div class="invalid-feedback"></div>
</div>
