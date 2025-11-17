<?php

namespace App\Http\Controllers;

use App\Helpers\CashMovementHelper;
use App\Helpers\ReceiptHelper;
use App\Http\Requests\StoreBookingBusyRequest;
use App\Models\Banner;
use App\Models\Booking;
use App\Models\BookingRoomStatus;
use App\Models\BookingStatus;
use App\Models\CashMovement;
use App\Models\CashRegisterSession;
use App\Models\Customer;
use App\Models\Person;
use App\Models\Room;
use App\Models\RoomLevel;
use App\Models\RoomStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceptionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomLevels = RoomLevel::where('active', 1)->get();
        $activeSession = CashRegisterSession::where('user_id', Auth::id())
                                            ->where('status', 'open')
                                            ->first();
        $isCashRegisterOpen = $activeSession ? true : false;
        
        $dateNow = Carbon::now()->format('Y-m-d\TH:i');
        return view('reception.home', compact('roomLevels', 'dateNow', 'isCashRegisterOpen'));
    }

    function aGetRoomByLevelId($roomLevelId, $datetime){
        $dateC = Carbon::createFromFormat('Y-m-d\TH:i', $datetime)->subMinutes(10);
//        $dateC = Carbon::parse($datetime);
        $rooms = null;
        if($roomLevelId > 0){
            $rooms = Room::where('room_level_id', $roomLevelId)->get();
        } else {
            $rooms = Room::all();
        }

        $roomFormat = [];
        foreach($rooms as $room) {
            /** @var Booking $booking */
//            $booking = $room->getBookingByDate(Carbon::now()->format('Y-m-d'));
            $booking = $room->getBookingByDate($dateC);
            $brStatus = trans('hotel-manager.'.RoomStatus::STATUS_AVAILABLE);
            $brStatusBg = RoomStatus::STATUS_AVAILABLE_COLOR;
            $brStatusIcon = RoomStatus::STATUS_AVAILABLE_ICON;
            $brStatusMsg = "";
            $bStatusName = "";
            $bookingId = -1;
            if ($booking) {
                $bookingId = $booking->id;
                /** @var \App\Models\RoomStatus $roomStatus */
                /** @var BookingStatus $bStatus */
                $bStatus = $booking->bookingLastStatus();
                $roomStatus = $room->roomStatus;
                if ($roomStatus && $roomStatus->active) {
                    $brStatus = $roomStatus->name;
                    $brStatusBg = config('bookings.state_colors')[$roomStatus->name];
                    $brStatusIcon = config('bookings.state_icons')[$roomStatus->name];
                    if($bStatus){
                        $brStatus = trans('hotel-manager.'.$bStatus->name) . " / " . trans('hotel-manager.'.$brStatus);
                    }
                } else {
                    if($bStatus){
                        $brStatus = trans('hotel-manager.'.$bStatus->name);
                        if(strcmp($bStatus->name, BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED) == 0 || strcmp($bStatus->name, BookingStatus::STATUS_RESERVATION_CONFIRMED) == 0){
                            $brStatusBg = config('bookings.booking_status_colors')[BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED];
                            $brStatus = trans('hotel-manager.'.$bStatus->name) . ReceiptHelper::entryInterval($booking->checkin_date);
                        } else {
                            if(strcmp($bStatus->name, BookingStatus::STATUS_INCOME) == 0){
                                $result = $dateC->lessThan($booking->checkout_date);
                                if(!$result){
                                    $brStatusBg = "#fc4b08";
                                    $brStatusMsg = "Salida del huesped esta con retraso!";
                                } else {
                                    $brStatusBg = $bStatus->color;
                                }

                            } else {
                                $brStatusBg = $bStatus->color;
                            }

                        }
                        $brStatusIcon = config('bookings.booking_status_icon')[$bStatus->name];
                    } else {
                        $brStatus = trans('hotel-manager.'.BookingRoomStatus::STATUS_RESERVATION);
                        $brStatusBg = BookingRoomStatus::STATUS_RESERVATION_COLOR;
                        $brStatusIcon = RoomStatus::STATUS_AVAILABLE_ICON;
                    }

                }

                if(strcmp($brStatus, BookingRoomStatus::STATUS_RESERVATION) === 0){
                    $now = Carbon::now();
                    $checkin = Carbon::create($booking->checkin_date);
                    $minutes = $checkin->diffInMinutes($now);
                    if($minutes >= 0 && $minutes <=5){
                        $brStatusMsg = "El cliente esta por llegar ";
                    }
                    if($minutes >= 6 && $minutes <= 60){
                        $brStatusMsg = "Preparar la habitacion";
                    }
                    $brStatusIcon = config('bookings.state_icons')[BookingRoomStatus::STATUS_RESERVATION];
                }
            } else {
                $roomStatus = $room->roomStatus;
                if($roomStatus && $roomStatus->active){
                    $brStatus = trans('hotel-manager.'.$roomStatus->name);
                    $brStatusBg = config('bookings.state_colors')[$roomStatus->name];
                    $brStatusIcon = config('bookings.state_icons')[$roomStatus->name];
                }
            }
            $roomFormat[] = [
                'id' => $room->id,
                'title' => $room->title,
                'roomType' => $room->roomType->title,
                'brStatusBg' => $brStatusBg,
                'brStatus' => $brStatus,
                'brStatusMsg' => $brStatusMsg,
                'bookingId' => $bookingId,
                'brStatusIcon' => $brStatusIcon
                ];
        }

        $view = view('reception._partials.tab_rooms', [
            'rooms' => $roomFormat
        ])->render();

        return response()->json(['view'=>$view]);
    }

    function aGetMenuRoomStatus(Request $request){
        $roomId = $request->post('roomId');
        $bookingId = $request->post('bookingId');

        $room = Room::find($roomId);
        $booking = Booking::find($bookingId);

        $view = view('reception._partials._menu_room_status', [
            'room' => $room,
            'booking' => $booking
        ])->render();

        return response()->json(['view'=>$view]);
    }

    function processRoom(Request $request, $roomId){
        $customerId = $request->input('customerId');
            if($customerId){
            dd($customerId);
        }
        $room = Room::find($roomId);
//        $startDate = Carbon::now()->format('Y-m-d\TH:i');
        $checkInTime = config('bookings.check-in-time');
        $checkOutTime = config('bookings.check-out-time');
        $startDate = Carbon::now()->setHour($checkInTime['hour'])->setMinute($checkInTime['minute'])->format('Y-m-d\TH:i');
        $endDate = Carbon::now()->addDay()->setHour($checkOutTime['hour'])->setMinute($checkOutTime['minute'])->format('Y-m-d\TH:i');

        return view('reception.process-room', compact('room', 'startDate', 'endDate'));
    }

    public function saveRoomBusy(StoreBookingBusyRequest $request){
        $typeIcon = "success";
        $title = "Se realizo la reserva";
        try{
            DB::beginTransaction();
            $customer = Customer::find($request->input('customerId'));
            $customer->send_email = $request->filled('customer.send_email')? $request->input('customer.send_email') : 0;
            $customer->save();
            // $booking->send_email = $request->filled('customer.send_email')? $request->input('customer.send_email') : 0;
            $booking = new Booking();
            $booking->room_id = $request->input('booking.room');
            $booking->customer_id = $request->input('customerId');
            $booking->checkin_date = $request->input('booking')['checkin_date'];
            $booking->checkout_date = $request->input('booking')['checkout_date'];
            $booking->ref = 'admin';
            $booking->total_adults = $request->input('booking')['total_adults'];
            $booking->total_children = $request->input('booking.total_children')? $request->input('booking.total_children') : 0;
            $booking->discount_type = $request->input('cost.discount_type');
            $booking->discount = $request->filled('cost.discount')? $request->input('cost.discount', 0) : 0;
            $booking->extra_charge = $request->filled('cost.extra_charge')? $request->input('cost.extra_charge', 0) : 0;
            $booking->forward = $request->input('cost.forward', null);
            if($booking->forward != null){
                $booking->forward_method_payment = $request->input('booking.forward_method_payment', "Effective");
                $booking->forward_payment_user = Auth::id();
            } else {
                $booking->forward_method_payment = null;
                $booking->forward_payment_user = null;
            }
//            $booking->cost = $request->filled('cost.total_pay')? $request->input('cost.total_pay', 0) : 0;
            $booking->cost = ReceiptHelper::getDayDiff($request->input('booking.checkin_date'), $request->input('booking.checkout_date')) * floatval($request->input('costTotal', 0));
            $booking->comments = $request->input('booking.comments', "");
            $booking->save();

            if($booking->forward != null){
                CashMovementHelper::createMovement(
                    $booking->forward, // amount
                    CashMovement::TYPE_INCOME, // type
                    $booking->forward_method_payment, // payment_method
                    'Ingreso a hospedaje directo checkin : ' . $booking->comments, // description
                    $booking // source
                );
            }

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $booking->id;
            $bookingStatus->name = BookingStatus::STATUS_INCOME;
            $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
            $bookingStatus->status_date = Carbon::now();
            $bookingStatus->user_id = Auth::id();
            $bookingStatus->save();
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la reserva, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }
        return redirect()->route('admin.reception.index')->with($typeIcon, $title);
    }
}
