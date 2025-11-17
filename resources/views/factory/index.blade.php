@extends('layout')
@section('content')
    @include('factory.include.modals.m_create_factory')
    @include('factory.include.modals.m_edit_factory')
    @include('factory.include.modals.m_delete_factory')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Fabricas
                                <a href="#" onclick="openFactoryCreateModal(); return false;" class="float-right btn btn-success btn-sm">{{ __('hotel-manager.add_new') }}</a>
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
                                        <th>Contacto</th>
                                        <th>Origen</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($factories as $factory)
                                        <tr>
                                            <td>{{ $factory->id }}</td>
                                            <td>{{ $factory->name }}</td>
                                            <td>{{ $factory->contact }}</td>
                                            <td>{{ $factory->origin }}</td>
                                            <td>
                                                <a href="#" class="text-danger float-right btn btn-sm btn-link" onclick="openFactoryDeleteModal({{$factory->id}}); return false;">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                                <a href="#" class="float-right btn btn-sm btn-link" onclick="openFactoryEditModal({{$factory->id}}); return false">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <!-- Enlaces de paginación con Bootstrap 4 -->
                                <div class="d-flex justify-content-center">
                                    {{ $factories->links() }}
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
