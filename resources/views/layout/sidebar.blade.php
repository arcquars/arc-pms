<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-hotel"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{url('admin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.cash-movements.home')}}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Movimientos de caja</span></a>
    </li>

    <li class="nav-item @if(request()->is('admin/booking')) active @endif">
        <a class="nav-link" href="{{url('admin/booking')}}">
            <i class="fas fa-hotel"></i>
            <span>{{ __('hotel-manager.bookings') }}</span>
        </a>
    </li>
    <li class="nav-item @if(request()->is('admin/reception/index')) active @endif">
        <a class="nav-link" href="{{route('admin.reception.index')}}">
            <i class="fas fa-hotel"></i>
            <span>{{ __('hotel-manager.Reception') }}</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
{{--    <div class="sidebar-heading">--}}
{{--        Administración--}}
{{--    </div>--}}

{{--    <li class="nav-item">--}}
{{--        <a class="nav-link @if(!request()->is('admin/banner*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#bannerSection"--}}
{{--           aria-expanded="true" aria-controls="collapseTwo">--}}
{{--            <i class="fas fa-fw fa-images"></i>--}}
{{--            <span>Banners Home</span>--}}
{{--        </a>--}}
{{--        <div id="bannerSection" class="collapse @if(request()->is('admin/banner*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <a class="collapse-item @if(request()->is('admin/banner/create')) active @endif" href="{{url('admin/banner/create')}}">Add New</a>--}}
{{--                <a class="collapse-item @if(request()->is('admin/banner')) active @endif" href="{{url('admin/banner')}}">View All</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}

{{--    <li class="nav-item @if(request()->is('admin/testimonials')) active @endif">--}}
{{--        <a class="nav-link " href="{{url('admin/testimonials')}}">--}}
{{--            <i class="fas fa-hotel"></i>--}}
{{--            <span>Testimonios de clientes</span></a>--}}
{{--    </li>--}}

    <!-- Heading -->
    <div class="sidebar-heading">
        Configurar Habitaciones
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @if(request()->is('admin/roomlevel*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/roomlevel*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTwo1"
           aria-expanded="true" aria-controls="collapseTwo1">
            <i class="fas fa-layer-group"></i>
            <span>{{ __('hotel-manager.room_level') }}</span>
        </a>
        <div id="collapseTwo1" class="collapse @if(request()->is('admin/roomlevel*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/roomlevel/create')) active @endif" href="{{url('admin/roomlevel/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/roomlevel')) active @endif" href="{{url('admin/roomlevel')}}">{{ __('hotel-manager.view_all') }}</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @if(request()->is('admin/roomtype*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/roomtype*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-table"></i>
            <span>{{ __('hotel-manager.room_type') }}</span>
        </a>
        <div id="collapseTwo" class="collapse @if(request()->is('admin/roomtype*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/roomtype/create')) active @endif" href="{{url('admin/roomtype/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/roomtype')) active @endif" href="{{url('admin/roomtype')}}">{{ __('hotel-manager.view_all') }}</a>
            </div>
        </div>
    </li>

    <!-- RoomMaster -->
    <li class="nav-item @if(request()->is('admin/rooms*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/rooms*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#roomMaster"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-box"></i>
            <span>{{ __('hotel-manager.room') }}</span>
        </a>
        <div id="roomMaster" class="collapse @if(request()->is('admin/rooms*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/rooms/create')) active @endif" href="{{url('admin/rooms/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/rooms')) active @endif" href="{{url('admin/rooms')}}">{{ __('hotel-manager.view_all') }}</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Recursos humanos
    </div>
    <!-- Department -->
    <li class="nav-item @if(request()->is('admin/department*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/department*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#DepartmentMaster"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-puzzle-piece"></i>
            <span>{{ __('hotel-manager.departments') }}</span>
        </a>
        <div id="DepartmentMaster" class="collapse @if(request()->is('admin/department*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/department/create')) active @endif" href="{{url('admin/department/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/department')) active @endif" href="{{url('admin/department')}}">{{ __('hotel-manager.view_all') }}</a>
            </div>
        </div>
    </li>

    <!-- Staff -->
    <li class="nav-item @if(request()->is('admin/staff*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/staff*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#StaffMaster"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>{{ __('hotel-manager.staff') }}</span>
        </a>
        <div id="StaffMaster" class="collapse @if(request()->is('admin/staff*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/staff/create')) active @endif" href="{{url('admin/staff/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/staff')) active @endif" href="{{url('admin/staff')}}">{{ __('hotel-manager.view_all') }}</a>
            </div>
        </div>
    </li>


    <!-- Heading -->
    <div class="sidebar-heading">
        Punto de venta
    </div>
    <!-- ProductMaster -->
    <li class="nav-item @if(request()->is('admin/product*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/product*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#ProductMaster"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Productos</span>
        </a>
        <div id="ProductMaster" class="collapse @if(request()->is('admin/product*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/product/create')) active @endif" href="{{url('admin/product/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/product')) active @endif" href="{{url('admin/product')}}">{{ __('hotel-manager.view_all') }}</a>
                <a class="collapse-item @if(request()->is('admin/product/category')) active @endif" href="{{url('admin/product/category')}}">Categorias</a>
                <a class="collapse-item @if(request()->is('admin/product/factory')) active @endif" href="{{url('admin/product/factory')}}">Fabricas</a>
            </div>
        </div>
    </li>
    <!-- CustomerMaster -->
    <li class="nav-item @if(request()->is('admin/customer*')) active @endif">
        <a class="nav-link @if(!request()->is('admin/customer*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#CustomerMaster"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('hotel-manager.customers') }}</span>
        </a>
        <div id="CustomerMaster" class="collapse @if(request()->is('admin/customer*')) show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(request()->is('admin/customer/create')) active @endif" href="{{url('admin/customer/create')}}">{{ __('hotel-manager.add_new') }}</a>
                <a class="collapse-item @if(request()->is('admin/customer')) active @endif" href="{{url('admin/customer')}}">{{ __('hotel-manager.view_all') }}</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{url('Auth/logout')}}">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Salir</span></a>
    </li>

</ul>
<!-- End of Sidebar -->
