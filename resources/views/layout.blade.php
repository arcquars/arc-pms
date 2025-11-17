<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin: A Hotel</title>

{{--    @if(!Session::has('adminData'))--}}
{{--        <script type="text/javascript">--}}
{{--            window.location.href="{{url('admin/login')}}";--}}
{{--        </script>--}}
{{--    @endif--}}

    <!-- Custom fonts for this template-->
    <link href="{{asset('public')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('public')}}/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{asset('public')}}/css/hotel-arc.css" rel="stylesheet">

    @livewireStyles

    @stack('head.end')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layout.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layout.navbar')

                @if ($errors->any())
                    <div class="alert alert-danger p-1 m-5" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><p class="m-0"><small>{{$error}}</small></p></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

                @livewire('cash-flow.cash-register-modal')
            </div>
            <!-- End of Main Content -->
            @include('layout.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para partir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione «Salir» a continuación si desea finalizar la sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="{{url('Auth/logout')}}">Salir</a>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('public')}}/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('public')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('public')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('public')}}/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/underscore@1.13.7/underscore-umd-min.js" type="text/javascript"></script>

    <!-- Custom moment js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js" integrity="sha512-Dz4zO7p6MrF+VcOD6PUbA08hK1rv0hDv/wGuxSUjImaUYxRyK2gLC6eQWVqyDN9IM1X/kUA8zkykJS/gEVOd3w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{asset('public')}}/js/booking.js"></script>
    <script>
        var listDiscount = [
        @foreach(config('bookings.discounts') as $discount)
        "{{ $discount }}",
        @endforeach
        ];
        $(document).ready(function(){
            @if (Session::has('success'))
            showAlert('success', '{{ Session::get('success') }}');
            @elseif(Session::has('error'))
            showAlert('error', '{{ Session::get('error') }}');
            @endif
        });
        function showAlert(typeIcon, title){
            Swal.fire({
                position: "top-end",
                icon: typeIcon,
                title: title,
                showConfirmButton: false,
                timer: 5800
            });
        }
    </script>
    @yield('scripts')
    @stack('js')

</body>

</html>
