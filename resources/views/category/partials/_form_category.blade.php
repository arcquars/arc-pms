@csrf
<div class="form-group">
    <input type="hidden" name="category" value="{{$category->id}}">
    <label for="c-name">Nombre <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" id="c-name" placeholder="" value="{{$category->name}}">
    <div class="invalid-feedback"></div>
</div>
