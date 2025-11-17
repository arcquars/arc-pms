@extends('layout')
@section('content')
    @include('category.include.modals.m_create_category')
    @include('category.include.modals.m_edit_category')
    @include('category.include.modals.m_delete_category')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Categorias
                                <a href="#" onclick="openCategoryCreateModal(); return false;" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.add_new') }}</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif

                                <table class="table table-bordered table-sm">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Creado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->created_at }}</td>
                                            <td>
                                                <a href="#" class="text-danger float-right btn btn-sm btn-link" onclick="openCategoryDeleteModal({{$category->id}}); return false;">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                                <a href="#" class="float-right btn btn-sm btn-link" onclick="openCategoryEditModal({{$category->id}}); return false">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <!-- Enlaces de paginación con Bootstrap 4 -->
                                <div class="d-flex justify-content-center">
                                    {{ $categories->links() }}
                                </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

@section('scripts')

<script>
    $(document).ready(function() {

    });
</script>

@endsection

@endsection
