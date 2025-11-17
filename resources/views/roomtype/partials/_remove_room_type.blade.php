@csrf
<input type="hidden" name="room_type_id" value="{{$roomType->id}}">
<div class="alert alert-danger" role="alert">
    Esta seguro de eliminar el tipo de habitación <b>{{$roomType->title}}</b>?
</div>
<div class="text-danger">
</div>
