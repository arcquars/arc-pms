@extends('layout')
@section('content')
    @include('product.includes.modals.m_delete_image')
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }
        .image-link {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .image-link:hover {
            background: rgba(0, 0, 0, 0.8);
        }
    </style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <form method="post" enctype="multipart/form-data" action="{{route('product.update', ['product' => $product])}}">
    @csrf
        @method('PUT')
        <input type="hidden" name="product" value="{{$product->id}}">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar Producto
                <div class="btn-group float-right" role="group" aria-label="Basic example">
                    <a href="{{url('admin/product')}}" class="btn btn-success btn-sm">{{ __('hotel-manager.view_all') }}</a>
                    <a href="{{url('admin/product/category')}}" class="btn btn-success btn-sm">Categorias</a>
                    <a href="{{url('admin/product/factory')}}" class="btn btn-success btn-sm">Fabricas</a>
                </div>

            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="pName">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="pName" name="name"
                          value="{{old('name', $product->name)}}" placeholder="">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="pCode">Codigo</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="pCode" name="code"
                           value="{{old('code', $product->code)}}" placeholder="">
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="pDescription">Descripcion</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="pDescription" name="description"
                           value="{{old('description', $product->description)}}" placeholder="">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-2 form-group">
                    <label for="pPriceRef">Precio Referencia <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price_reference') is-invalid @enderror" id="pPriceRef"
                           step="0.01"
                           value="{{old('price_reference', $product->price_reference)}}" name="price_reference" placeholder="">
                    @error('price_reference')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-2 form-group">
                    <label for="pPriceMinimum">Precio minimo <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('price_minimum') is-invalid @enderror" id="pPriceMinimum"
                           value="{{old('price_minimum', $product->price_minimum)}}" name="price_minimum" placeholder="">
                    @error('price_minimum')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="col-md-2 form-group">
                    <label for="pCoste">Costo</label>
                    <input type="number" class="form-control @error('coste') is-invalid @enderror" id="pCoste" name="coste"
                           value="{{old('coste', $product->coste)}}" placeholder="" />
                    @error('coste')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="pCategory">Categoria <span class="text-danger">*</span></label>
                        <select name="category" id="pCategory" class="form-control @error('category') is-invalid @enderror">
                            @foreach($categories as $key => $category)
                                @if(old('category'))
                                    <option value="{{$key}}" @if(old('category') && old('category') == $key) selected @endif>{{$category}}</option>
                                @else
                                    <option value="{{$key}}" @if(strcmp($product->category, $key) == 0) selected @endif>{{$category}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="pFactory">Fabrica <span class="text-danger">*</span></label>
                        <select name="factory" id="pFactory" class="form-control @error('factory') is-invalid @enderror" >
                            @foreach($factories as $key => $factory)
                                @if(old('factory'))
                                    <option value="{{$key}}" @if(old('factory') && old('factory') == $key) selected @endif >{{$factory}}</option>
                                @else
                                    <option value="{{$key}}" @if($product->factory == $key) selected @endif >{{$factory}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('factory')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="pMeasure">Medida <span class="text-danger">*</span></label>
                        <select name="measure" id="pMeasure" class="form-control @error('measure') is-invalid @enderror">
                            @foreach($measures as $key => $measure)
                                @if(old('measure'))
                                <option value="{{$key}}" @if(old('measure') && old('measure') == $key) selected @endif>{{$measure}}</option>
                                @else
                                    <option value="{{$key}}" @if($product->measure == $key) selected @endif>{{$measure}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('measure')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-switch d-inline">
                            <input type="checkbox" class="custom-control-input" name="type" id="pType" onchange="updateType(this);" value="PRODUCT" checked>
                            <label class="custom-control-label" for="pType">Producto</label>
                        </div>|
                        <div class="custom-control custom-switch d-inline">
                            <input type="checkbox" class="custom-control-input" name="active" id="pActive" value="1"
                                    @if(old('active', $product->active))
                                        checked
                                    @endif >
                            <label class="custom-control-label" for="pActive">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="image_product" class="custom-file-input @error('image_product') is-invalid @enderror" id="inputProductImage" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputProductImage">Choose file</label>
                    </div>
                </div>
            @error('image_product')
            <div class="invalid text-danger text-small">
                {{ $message }}
            </div>
            @enderror

            @if($product->filename)
            <div class="d-flex justify-content-center" style="width: 100%;">
                <div class="image-container" style="width: 20%;">
                    <img src="{{ asset($product->path_image) }}" class="img-thumbnail" alt="Archivo">
                    <button class="image-link btn btn-danger btn-sm" onclick="openProductImageDeleteModal({{$product->id}}); return false;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            @endif

        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary btn-sm float-right">Crear</button>
        </div>
    </div>
    </form>
</div>
                <!-- /.container-fluid -->
@endsection
@push('js')
    <script>
        $( document ).ready(function() {
            @if(old('measure'))
            $('#pType').val("{{old('measure')}}");
            @else
                @if($product->measure == $unitServiceId)
                    $('#pType').prop("checked", false);
                @else
                    $('#pType').prop("checked", true);
                @endif
            @endif
            updateType($('#pType'));

            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            $('#pMeasure').on('change', function() {
                const option = $(this).val();
                if(option === "{{$unitServiceId}}"){
                    $('#pType').prop("checked", false);
                } else {
                    $('#pType').prop("checked", true);
                }
                updateType('#pType');
            });
        });

        function updateType(check){
            if($(check).is(":checked")){
                $(check).next().text("{{__('hotel-manager.PRODUCT')}}");
                $('#pMeasure').removeAttr('disabled');
                //$('#pMeasure').val('');
            } else {
                $(check).next().text("{{__('hotel-manager.SERVICE')}}");
                // $('#pMeasure').prop('disabled', 'true');
                $('#pMeasure').val('{{$unitServiceId}}');
                $('#pMeasure').addClass('disabled');
            }
        }
    </script>

@endpush
