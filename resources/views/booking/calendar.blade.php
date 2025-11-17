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

    @include('booking.include.modals.m_create_booking', ["roomLevels" => $roomLevels])
    @include('booking.include.modals.m_edit_booking', ["roomLevels" => $roomLevels])
    @include('booking.include.modals.m_search_person')
    <style>
        .ec-timeline .ec-time, .ec-timeline .ec-line {
            width: 80px;
        }
    </style>
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('hotel-manager.calendar') }}
                                <a href="#" onclick="openBookingCreateModal(null); return false;" class="float-right btn btn-success btn-sm ml-2">
                                    {{ __('hotel-manager.new_booking') }}
                                </a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(Session::has('success'))
                            <p class="text-success">{{session('success')}}</p>
                            @endif
                                <main class="row">
                                    <div id="mycalendar" class="col"></div>
                                </main>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@event-calendar/build@3.7.2/event-calendar.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@event-calendar/build@3.7.2/event-calendar.min.js"></script>


    <script>
        let eventCalendar = null;
    $(document).ready(function() {
        getRooms();

    });



    function createEvents() {
        let days = [];
        for (let i = 0; i < 7; ++i) {
            let day = new Date();
            let diff = i - day.getDay();
            day.setDate(day.getDate() + diff);
            days[i] = day.getFullYear() + "-" + _pad(day.getMonth()+1) + "-" + _pad(day.getDate());
        }

        return [
            {start: days[0] + " 00:00", end: days[0] + " 09:00", resourceId: 1, display: "background"},
            {start: days[1] + " 12:00", end: days[1] + " 14:00", resourceId: 2, display: "background"},
            {start: days[2] + " 17:00", end: days[2] + " 24:00", resourceId: 1, display: "background"},
            {start: days[0] + " 10:00", end: days[0] + " 14:00", resourceId: 1, title: "The calendar can display background and regular events", color: "#FE6B64"},
            {start: days[1] + " 16:00", end: days[2] + " 08:00", resourceId: 2, title: "An event may span to another day", color: "#B29DD9"},
            {start: days[2] + " 09:00", end: days[2] + " 13:00", resourceId: 2, title: "Events can be assigned to resources and the calendar has the resources view built-in", color: "#779ECB"},
            {start: days[3] + " 14:00", end: days[3] + " 20:00", resourceId: 1, title: "", color: "#FE6B64"},
            {start: days[3] + " 15:00", end: days[3] + " 18:00", resourceId: 1, title: "Overlapping events are positioned properly", color: "#779ECB"},
            {start: days[5] + " 10:00", end: days[5] + " 16:00", resourceId: 2, title: {html: "You have complete control over the <i><b>display</b></i> of events…"}, color: "#779ECB"},
            {start: days[5] + " 14:00", end: days[5] + " 19:00", resourceId: 2, title: "…and you can drag and drop the events!", color: "#FE6B64"},
            {start: days[5] + " 18:00", end: days[5] + " 21:00", resourceId: 2, title: "", color: "#B29DD9"},
            {start: days[1], end: days[3], resourceId: 1, title: "All-day events can be displayed at the top", color: "#B29DD9", allDay: true}
        ];
    }

    function _pad(num) {
        let norm = Math.floor(Math.abs(num));
        return (norm < 10 ? '0' : '') + norm;
    }

    function getRooms(){
        $.ajax({
            url:"{{url('admin/booking/get-rooms')}}",
            dataType:'json',
            beforeSend:function(){
                // return [];
            },
            success:function(res){
                console.log("datos::", res.data);
                eventCalendar = loadEventCalendar(res.data);
            }
        });

    }

    function loadEventCalendar(data){
        return new EventCalendar(document.getElementById('mycalendar'), {
            // view: 'resourceTimelineMonth',
            view: 'dayGridMonth',
            headerToolbar: {
                start: 'prev,next',
                center: 'title',
                end: 'resourceTimelineWeek, resourceTimelineMonth'
            },
            // buttonText: {resourceTimelineWeek: 'Semana', resourceTimelineMonth: 'Mes'},
            buttonText: {close: 'Close', dayGridMonth: 'month', listDay: 'list', listMonth: 'list',
                listWeek: 'list', listYear: 'list', resourceTimeGridDay: 'resources',
                resourceTimeGridWeek: 'resources', resourceTimelineDay: 'timeline',
                resourceTimelineMonth: 'Linea mes', resourceTimelineWeek: 'Linea semana',
                timeGridDay: 'day', timeGridWeek: 'week', today: 'today'},
            // resources: [
            //     {id: 1, title: 'Resource A', extendedProps: {state: 'Close'}},
            //     {id: 2, title: 'Resource B', extendedProps: {state: 'Open'}}
            // ],
            resources: data,
            resourceLabelContent: function (info) {
                // console.log(JSON.stringify(info.resource.extendedProps.state));
                if("state" in info.resource.extendedProps){
                    // return {html: '<p><b>'+info.resource.title+'</b> ('+info.resource.extendedProps.state+')</p>'};
                    return {html: info.resource.title+' ('+info.resource.extendedProps.state+')'};
                } else {
                    // return {html: '<p><b>'+info.resource.title+'</b></p>'};
                    return {html: info.resource.title};
                }

            },
            dateClick: function (event) {
                console.log("eee 1: ", event);
                openBookingCreateModal(event.dateStr);
            },
            eventClick: function (info){
                console.log("eee:: ", info.event.id);
                if(typeof openbookingEditModal === "function" ){
                    openbookingEditModal(info.event.id);
                }
                // alert(info);
            },
            scrollTime: '09:00:00',
            // events: createEvents(),
            eventSources: [{events: function() {
                    console.log('fetching...');
                    return [];
                }}, {url: '{{ url('/admin/booking/a-get-events') }}'}],
            views: {
                timeGridWeek: {pointer: true},
                resourceTimeGridWeek: {pointer: true},
                resourceTimelineWeek: {
                    pointer: true,
                    slotMinTime: '09:00',
                    slotMaxTime: '21:00',
                    // slotWidth: 80,
                }
            },
            dayMaxEvents: true,
            nowIndicator: true,
            selectable: true,
            select: function (info){
                // ec.addEvent({start: "2024-11-240 15:00", end: "2024-11-28 18:00", resourceId: 1, title: "Overlapping events are positioned properly", color: "#779ECB"});
                console.log("eee 2", info);
            }
        });
    }
</script>
@endsection
