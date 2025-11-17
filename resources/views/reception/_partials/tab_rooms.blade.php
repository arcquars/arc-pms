<div class="row">
    @foreach($rooms as $room)
    <div class="col-md-2">
        <div class="small-box" style="background-color: {{$room['brStatusBg']}}">
            <div class="inner">
                <h4 class="text-white">{{ $room['title'] }}</h4>
                @if(empty($room['brStatusMsg']))
                <h6 class="text-white">{{ $room['roomType'] }}</h6>
                    @else
                    <p class="text-white">{{$room['brStatusMsg']}}</p>
                @endif
            </div>
            <div class="icon">
                <i class="{{$room['brStatusIcon']}}"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="reservation-popover"
               data-html="true" data-placement="left" data-content='<div class="fa-2x text-center"><i class="fas fa-spinner fa-spin"></i></div>'
               data-template='<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>'
               data-id="{{$room['id']}}" data-booking-id="{{$room['bookingId']}}"
            >
                {!! $room['brStatus'] !!}  <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

    </div>
    @endforeach
</div>
