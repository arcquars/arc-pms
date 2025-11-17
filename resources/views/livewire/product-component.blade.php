<div>
    <!-- Campo de búsqueda -->
    <input type="text" wire:model="search" class="form-control mb-3" placeholder="Buscar producto...">

    <div class="table-responsive">
        <!-- Tabla de productos -->
        <table class="table table-sm table-striped">
            <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Precio ref.</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                    <td>${{ number_format($product->price_reference, 2) }}</td>
                    <td class="text-right">
                        <a href="{{route('product.edit', ['product' => $product->id])}}" class="btn btn-link btn-sm"><i class="far fa-edit"></i></a>
                        <a href="#" class="btn btn-link btn-sm text-danger"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <!-- Paginación -->
    <div class="d-flex justify-content-center">
    {{ $products->appends(['search' => $search])->links() }} <!-- ✅ Muestra la paginación con Bootstrap -->
    </div>

    @if(count($products) === 0)
        <p class="text-center">No se encontraron productos.</p>
    @endif
</div>
