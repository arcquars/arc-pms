<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"
            type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation"
    >
        <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <!-- Topbar Navbar -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="true">
                    Reportes
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('admin.report.consolidated_by_day')}}">Consolidado por dia</a>
                    <a class="dropdown-item" href="{{route('admin.report.consolidated_by_range')}}">Consolidado por rango</a>
                    <a class="dropdown-item" href="#">Histórico de Huéspedes</a>
                    <a class="dropdown-item" href="#">Resumen de ingresos</a>
{{--                    <div class="dropdown-divider"></div>--}}
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    Administración
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{url('admin/banner')}}"><i class="fas fa-fw fa-images"></i> Banners Home</a>
                    <a class="dropdown-item" href="{{url('admin/testimonials')}}"><i class="fas fa-hotel"></i> Testimonios de clientes</a>
                    <a class="dropdown-item" href="{{url('admin/service')}}"><i class="fas fa-table"></i> {{ __('hotel-manager.Services') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Usuarios</a>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="Livewire.emit('open-cash-register-modal')">
                    <i class="fas fa-fw fa-cash-register"></i>
                    <span>Gestionar Caja</span>
                </a>
            </li>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-profile rounded-circle"
                         src="{{asset('public')}}/img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{url('Auth/logout')}}" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Salir
                    </a>
                </div>
            </li>

        </ul>
    </div>



</nav>
<!-- End of Topbar -->
