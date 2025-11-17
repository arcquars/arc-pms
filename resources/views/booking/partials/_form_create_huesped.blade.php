<form onsubmit="saveHuesped(this); return false;">
    @csrf
    <input type="hidden" name="booking_id" value="{{$booking->id}}">
<div class="row">
    <div class="col-md-4 form-group">
        <label for="hName">Nombre</label>
        <input type="text" class="form-control form-control-sm" name="name" id="hName" required>
    </div>
    <div class="col-md-3 form-group">
        <label for="hDocument">Doc. identidad</label>
        <input type="text" class="form-control form-control-sm" name="document" id="hDocument" required>
    </div>
    <div class="col-md-3 form-group">
        <label for="pCountry">Pais</label>
        <select name="country" id="pCountry" class="form-control form-control-sm" required>
            <option value="">Seleccione...</option>
            @foreach($countries as $country)
                <option value="{{$country}}">{{$country}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 form-group d-flex align-items-end">
        <button class="btn btn-sm btn-primary align-self-end btn-block" type="submit">
            <i class="far fa-plus-square"></i>
        </button>
    </div>
</div>
</form>

<div class="table-responsive">
    <table class="table">
        <tbody>
        @foreach($huespedes as $huesped)
        <tr>
            <td>
                {{ $huesped->name }} | {{ $huesped->document }} | {{ $huesped->country }}
            </td>
            <td class="text-right">
                <button class="btn btn-sm btn-danger" onclick="deleteHuesped({{$huesped->id}}); return false">
                    <i class="far fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
