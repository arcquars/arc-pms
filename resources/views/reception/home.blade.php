@extends('layout')
@section('content')
    @if(!$isCashRegisterOpen)
        
        {{-- 1. Estilos CSS para el overlay y el mensaje --}}
        <style>
            /* * Creamos un backdrop personalizado usando position: fixed
             * para asegurar que cubra toda la pantalla.
             */
            .custom-page-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                /* Usamos el z-index estándar del backdrop de modal (1040) */
                z-index: 1040;
                background-color: #000;
                opacity: 0.65; /* Un poco más oscuro que el estándar (0.5) */
            }

            /* * El contenedor del mensaje (UI/UX).
             * Debe estar encima del backdrop (z-index 1041).
             */
            .backdrop-message-container {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1041; /* Encima del backdrop */
                color: white;
                text-align: center;
                background-color: #343a40; /* bg-dark */
                padding: 2.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 8px 20px rgba(0,0,0,0.5);
                width: 90%;
                max-width: 500px;
            }
        </style>

        {{-- 2. El HTML del Backdrop (simula el 'modal-backdrop') --}}
        <div class="custom-page-backdrop"></div>

        {{-- 3. El Mensaje (¡Importante para UI/UX!) --}}
        <div class="backdrop-message-container">
            {{-- Icono de FontAwesome (si lo usas) --}}
            <h2 class="text-warning mb-3">
                <i class="fas fa-cash-register fa-2x"></i>
            </h2>
            
            <h4 class="mb-3">Se requiere una sesión de caja activa</h4>
            <p class="mb-4">
                Debes abrir tu caja antes de poder interactuar con el calendario o registrar reservas.
            </p>
            
            {{-- 
              Este botón dispara el evento de Livewire que abre el modal 
              'CashRegisterModal' que implementamos antes.
            --}}
            <a href="{{ url('/admin') }}" class="btn btn-sm btn-primary">Panel de control</a>
            <button 
                type="button" 
                class="btn btn-sm btn-success" 
                onclick="Livewire.emit('open-cash-register-modal')">
                <i class="fas fa-lock-open"></i>
                Abrir Caja Ahora
            </button>
        </div>
    @endif
    @include('room-status.include.modals.m_create_room_status')
    @include('room-status.include.modals.m_close_room_status')
    @include('booking-status.include.modals.m_create_booking_status')
    @include('reception.includes.models.m_selling_product')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recepción</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="dateSearch">Fecha</label>
                        <input type="datetime-local" name="date_search" id="dateSearch" class="form-control form-control-sm"
                               onchange="reloadTab();" value="{{ $dateNow }}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-9 d-flex align-items-end mb-3">
                        <a href="#" onclick="reloadDateNow(); return false;">Hora actual</a>
                    </div>
                </div>
                <ul id="tabRoomLevels" class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="level-0-tab" href="#" data-toggle="tab" data-target="#rl-0" data-id="0" role="tab"
                           aria-controls="home" aria-selected="false">
                            Todos
                        </a>
                    </li>
                    @foreach($roomLevels as $roomLevel)
                    <li class="nav-item">
                        <a class="nav-link" id="level-{{$roomLevel->id}}-tab" href="#" data-toggle="tab" data-target="#rl-{{$roomLevel->id}}" data-id="{{$roomLevel->id}}" role="tab"
                           aria-controls="home" aria-selected="false">
                            {{ $roomLevel->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content border-bottom border-left border-right p-2">
                    <div class="tab-pane active" id="rl-0" role="tabpanel" aria-labelledby="level-0-tab">
                        <p>Sin datos...</p>
                    </div>
                    @foreach($roomLevels as $roomLevel)
                    <div class="tab-pane" id="rl-{{$roomLevel->id}}" role="tabpanel" aria-labelledby="level-{{$roomLevel->id}}-tab">
                        <p>Sin datos...</p>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <script type="text/template" id="template_room_level_tab">
        <div class="fa-3x text-center">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </script>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('#tabRoomLevels li:first-child a').tab('show');
        });

        $(document).ready(function(){

            reloadDateNow();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
            const dateNow = $("#dateSearch").val();
            if(dateNow === ""){
                alert("La fecha es un campo obligatorio");
                $("#dateSearch").addClass('is-invalid');
                $("#dateSearch").next().text("La fecha es un campo obligatorio");
                //
                return false;
            } else {
                $("#dateSearch").removeClass('is-invalid');
                $("#dateSearch").next().empty();
            }
            const target = event.target; // newly activated tab
            const tabPanel = $(target).attr("data-target");
            const roomLevelId = $(target).attr("data-id");


            const templateRoomLevelTab = _.template($("#template_room_level_tab").html());

            $.ajax({
                url:"{{url('admin/reception/a-get-level-rooms-tab')}}" + "/" + roomLevelId + "/" + dateNow,
                type: 'get',
                dataType:'json',
                beforeSend:function(){
                    $(tabPanel).empty().append(templateRoomLevelTab());
                },
                success:function(res){
                    $(tabPanel).empty().append(res.view);
                    reloadPopoverMenu();
                },
                error: function (data) {
                }
            });
        });

        function openMenuBookingStatus(roomId, bookingId){
            alert(roomId + " | " + bookingId);
        }

        function reloadPopoverMenu(){
            // alert($('#pMenuRoomStatus').html());
            $('[data-toggle="reservation-popover"]').popover('dispose');

            $('[data-toggle="reservation-popover"]').popover({
                trigger: 'manual',
                html: true,
                sanitize: false
            }).on('click', function(e) {
                // Evitar que el popover se cierre al hacer clic en el enlace
                e.preventDefault();
                $(this).popover('toggle');
            });
            // Cerrar el popover al hacer clic fuera de él
            $(document).on('click', function(e) {
                if ($(e.target).data('toggle') !== 'reservation-popover'
                    && $(e.target).parents('[data-toggle="reservation-popover"]').length === 0
                    && $(e.target).parents('.popover.in').length === 0) {
                    $('[data-toggle="reservation-popover"]').popover('hide');
                }
            });


            $('[data-toggle="reservation-popover"]').on('inserted.bs.popover', function () {
                // console.log("eeee:: " + $(this).attr("data-id"));
                const roomId = $(this).attr("data-id");
                const bookingId = $(this).attr("data-booking-id");
                const popover = this;
                $.ajax({
                    url: '{{route('admin.reception.getMenuRoomStatus')}}',
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        roomId, bookingId
                    },
                    cache: false,
                    success: function (data) {
                        // $(popover).attr('data-content', data.view).popover('update');
                        $(".popover-body").empty().append(data.view);
                        // click-menu
                        $( ".click-menu" ).on( "click", function() {
                            alert( "Handler for `click` called." );
                        } );
                    }
                });
            });

            $('[data-toggle="reservation-popover"]').on('show.bs.popover', function () {
                $('[data-toggle="reservation-popover"]').popover('hide');
            });
        }

        function reloadTab(){
            tabActive = $('#tabRoomLevels').find('a.active');
            $(tabActive).removeClass('active');
            $(tabActive).tab('show');
        }

        function reloadDateNow(){
            // dateSearch datetime-local
            $.ajax({
                url: '{{route('admin.booking.a_get_date_now')}}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                cache: false,
                success: function (data) {
                    // alert(data.now);
                    $("#dateSearch").val(data.now);
                    reloadTab();
                }
            });
        }

    </script>
@endsection
