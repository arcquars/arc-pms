<?php

namespace App\Http\Controllers;

use App\Helpers\BookingHelper;
use App\Helpers\CashMovementHelper;
use App\Helpers\ReceiptHelper;
use App\Http\Requests\StoreBookingCostRequest;
use App\Http\Requests\StoreReceiptPost;
use App\Http\Requests\UpdateBookingFinalRequest;
use App\Models\BookingStatus;
use App\Models\CashMovement;
use App\Models\CashRegisterSession;
use App\Models\Category;
use App\Models\ExtraSales;
use App\Models\Huesped;
use App\Models\Person;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Room;
use App\Models\RoomLevel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\RoomType;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

// use Stripe\Stripe;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roomSelect = $request->has('room')? $request->get('room') : "";
        $dateSelect = $request->has('date')? $request->get('date') : "";
        $customerSelect = $request->has('customer')? $request->get('customer') : "";
        $roomsForSelect = Room::where('active', 1)->orderBy('title')->pluck('title', 'id');
        $bookings=Booking::where('active', 1)->whereHas('bookingStatus', function ($query){
            $query->where('name', 'like', BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED)
                ->whereOr('name', 'like', BookingStatus::STATUS_RESERVATION_CONFIRMED);
        })->orderBy('checkin_date', 'desc')->paginate(5);

        return view('booking.index',[
            'data'=>$bookings,
            'roomsForSelect' => $roomsForSelect,
            'roomSelect' => $roomSelect,
                'dateSelect' => $dateSelect,
                'customerSelect' => $customerSelect
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers=Customer::all();
        return view('booking.create',['data'=>$customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'=>'required',
            'room_id'=>'required',
            'checkin_date'=>'required',
            'checkout_date'=>'required',
            'total_adults'=>'required',
            'roomprice'=>'required',
        ]);


        if($request->ref=='front'){
            $sessionData=[
                'customer_id'=>$request->customer_id,
                'room_id'=>$request->room_id,
                'checkin_date'=>$request->checkin_date,
                'checkout_date'=>$request->checkout_date,
                'total_adults'=>$request->total_adults,
                'total_children'=>$request->total_children,
                'roomprice'=>$request->roomprice,
                'ref'=>$request->ref
            ];
            session($sessionData);
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                  'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                      'name' => 'T-shirt',
                    ],
                    'unit_amount' => $request->roomprice*100,
                  ],
                  'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/laravel-apps/hotelManage/booking/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://localhost/laravel-apps/hotelManage/booking/fail',
            ]);
            return redirect($session->url);
        }else{
            $data=new Booking;
            $data->customer_id=$request->customer_id;
            $data->room_id=$request->room_id;
            $data->checkin_date=$request->checkin_date;
            $data->checkout_date=$request->checkout_date;
            $data->total_adults=$request->total_adults;
            $data->total_children=$request->total_children;
            if($request->ref=='front'){
                $data->ref='front';
            }else{
                $data->ref='admin';
            }
            $data->save();

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $data->id;
            $bookingStatus->color = config('bookings.state_colors')[BookingStatus::COLOR_AVAILABLE];
            $bookingStatus->save();
            return redirect('admin/booking/create')->with('success','Data has been added.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        Booking::where('id',$id)->delete();
        $booking = Booking::find($id);
        $booking->active = 0;
        $booking->save();
        return redirect('admin/booking')->with('success','Data has been deleted.');
    }


    // Check Avaiable rooms
    function available_rooms(Request $request,$checkin_date){
        $arooms=DB::SELECT("SELECT * FROM rooms WHERE id NOT IN (SELECT room_id FROM bookings WHERE '$checkin_date' BETWEEN checkin_date AND checkout_date)");

        $data=[];
        foreach($arooms as $room){
            $roomTypes=RoomType::find($room->room_type_id);
            $data[]=['room'=>$room,'roomtype'=>$roomTypes];
        }

        return response()->json(['data'=>$data]);
    }

    public function front_booking()
    {
        return view('front-booking');
    }

    function booking_payment_success(Request $request){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
        $customer = \Stripe\Customer::retrieve($session->customer);
        if($session->payment_status=='paid'){
            // dd(session('customer_id'));
            $data=new Booking;
            $data->customer_id=session('customer_id');
            $data->room_id=session('room_id');
            $data->checkin_date=session('checkin_date');
            $data->checkout_date=session('checkout_date');
            $data->total_adults=session('total_adults');
            $data->total_children=session('total_children');
            if(session('ref')=='front'){
                $data->ref='front';
            }else{
                $data->ref='admin';
            }
            $data->save();
            return view('booking.success');
        }
    }

    function booking_payment_fail(Request $request){
        return view('booking.failure');
    }

    public function calendar()
    {
        $roomLevels = RoomLevel::where('active', 1)->get();

        $activeSession = CashRegisterSession::where('user_id', Auth::id())
                                            ->where('status', 'open')
                                            ->first();
        $isCashRegisterOpen = $activeSession ? true : false;

        return view('booking.calendar', compact('roomLevels', 'isCashRegisterOpen'));
    }

    function a_getEvents(Request $request){
        $start = $request->get('start');
        $end = $request->get("end");

        $startC = Carbon::parse($start);
        $endC = Carbon::parse($end);
//        $bookings = Booking::whereBetween('checkin_date', [$startC->format('Y-m-d'), $endC->format('Y-m-d')])->get();

//        $bookings = Booking::where('checkin_date', '>=', $startC->format('Y-m-d'))
//            ->orWhere('checkout_date', '<=', $endC->format('Y-m-d'))
//            ->where('active', "=", "1")
//            ->get();

        $bookings = Booking::where('active', "=", "1")->where(function ($query) use ($startC, $endC) {
            $query->whereBetween('checkin_date', [$startC->format('Y-m-d'), $endC->format('Y-m-d')])
                ->orWhereBetween('checkout_date', [$startC->format('Y-m-d'), $endC->format('Y-m-d')]);
        })->get();

        $results = [];
        foreach ($bookings as $booking) {
            $color = config('bookings.state_colors')[BookingStatus::COLOR_AVAILABLE];
            if($booking->last_status != null){
                $color = $booking->last_status->color;
            }
            $results[] = [
                'start' => Carbon::parse($booking->checkin_date)->format('Y-m-d') . ' 16:00',
                'end' => Carbon::parse($booking->checkout_date)->format('Y-m-d') . ' 16:00',
                'id' => $booking->id,
                'resourceId' => "H-".$booking->room_id,
                'title' => ($booking->room)? $booking->room->title : '',
                'color' => $color
            ];
        }

        Log::info("PDM 3232:: " . count($results) . " || " . $startC->format('Y-m-d') . " || " . $endC->format('Y-m-d') );
        return response()->json($results);
    }

    // Check Avaiable rooms
    function aGetRooms(Request $request){
        $rLevels = RoomLevel::where('active', 1)->get();

        $data=[];
        foreach($rLevels as $rLevel){
            $row = ["id" => $rLevel->id, "title" => $rLevel->name];
            $rooms = [];
            foreach ($rLevel->rooms as $room){
                $rooms[] = ['id' => "H-".$room->id, "title" => $room->title, "extendedProps" => ['state' => "1"]];
            }
            if(count($rooms) > 0){
                $row["children"] = $rooms;
            }

            $data[]= $row;
        }

        return response()->json(['data'=>$data]);
    }

    function aGetBookingById(Request $request){
        $bookingId = $request->post('booking_id');

        /** @var Booking $booking */
        $booking = Booking::find($bookingId);
        $bookingStatus = $booking->bookingLastStatus();

        $bookingStatusValid = BookingHelper::getBookingStatusValid($bookingStatus->name);

        $now = Carbon::now()->format('Y-m-d\TH:i');
        $activeEdit = true;
        if(strcmp($bookingStatus->name, BookingStatus::STATUS_HOSTING_COMPLETED) == 0 ||
            strcmp($bookingStatus->name, BookingStatus::STATUS_NO_INCOME) == 0 ||
            strcmp($bookingStatus->name, BookingStatus::STATUS_INCOME) == 0
        ){
            $activeEdit = false;
        }

        return response()->json([
            'booking'=>$booking,
            'room'=>$booking->room,
            'roomType'=>$booking->room->roomType,
            'bookingStatus' => $bookingStatus,
            'person' => $booking->customer->person,
            'customer' => $booking->customer,
            'bookingStatusValid' => $bookingStatusValid,
            'activeEdit' => $activeEdit,
            'now' => $now
            ]);
    }

    function aGetDateNow(){
        $now = Carbon::now()->format('Y-m-d\TH:i');
        return response()->json([
            'now' => $now
        ]);
    }

    function aGetBookingModalBody(Request $request){
        $bookingId = $request->post('booking_id');
        $nextBookingStatus = $request->post('bookingStatus');

        /** @var Booking $booking */
        $booking = Booking::find($bookingId);
        $bookingStatus = $booking->bookingLastStatus();

//        $now = Carbon::now()->format('Y-m-d\TH:i');
        $now = Carbon::now();

        $html = view('booking.partials._modal_body_booking_form', [
            'booking'=>$booking,
            'room'=>$booking->room,
            'roomType'=>$booking->room->roomType,
            'bookingStatus' => $bookingStatus,
            'nextBookingStatus' => $nextBookingStatus,
            'person' => $booking->customer->person,
            'customer' => $booking->customer,
            'now' => $now
        ])->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    function aUpdateBookingStateNoConfirmed(StoreBookingCostRequest $request){
        $typeIcon = "success";
        $title = "Se actualizo la Reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();

            $booking = Booking::find($request->input('booking_id'));
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
            $booking->comments = $request->input('booking.comments', "");
            $booking->save();

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $booking->id;
            $bookingStatus->name = BookingStatus::STATUS_INCOME;

            $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
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

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    function aUpdateBookingStateConfirmed(Request $request){
        $typeIcon = "success";
        $title = "Se actualizo la Reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();

            $booking = Booking::find($request->input('booking_id'));

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $booking->id;

            $nextStatus = $request->input('booking_status_next');
            if(strcmp($nextStatus, BookingStatus::STATUS_NO_INCOME) == 0){
                $checkin = $booking->checkin_date;
                $booking->checkout_date = $checkin->format('Y-m-d') . ' 06:00:00';
                $booking->checkin_date = $checkin->format('Y-m-d') . ' 13:58:00';
                $booking->save();
            }

            $bookingStatus->name = $nextStatus;

            $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
            $bookingStatus->user_id = Auth::id();
            $bookingStatus->save();
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage() . " || " . $request->input('booking_status_next'));
            $typeIcon = "error";
            $title = "No Se grabo la reserva, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    function aUpdateBookingStateNotIncome(Request $request){
        $request->validate([
            'booking.comments' => 'required|string|max:255'
        ]);

        $typeIcon = "success";
        $title = "Se actualizo la Reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();

            $booking = Booking::find($request->input('booking_id'));
            $booking->comments = $request->input('booking.comments', "");
            $booking->checkout_date = $booking->checkin_date;
            $booking->active = true;
            $booking->save();

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $booking->id;
            $bookingStatus->name = BookingStatus::STATUS_NO_INCOME;

            $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
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

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    function aUpdateBookingStateIncome(UpdateBookingFinalRequest $request){
        $typeIcon = "success";
        $title = "Se actualizo la Reserva";
        $result = true;
        $resultCode = 200;

        $bookingId = $request->post('booking_id');
        $penalty = floatval($request->post('penalty', 0));
        $methodPayment = $request->post('method_payment');

        $this->saveBookingStatusHostingCompleted($bookingId, $penalty, $methodPayment, $typeIcon, $title, $result, $resultCode);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    function statusBooking($bookingId){
        $booking = Booking::find($bookingId);
        $formActive = strcmp($booking->last_status->name, BookingStatus::STATUS_INCOME) == 0;
        return view('booking.status-booking', compact('booking', 'formActive'));
    }

    function terminateStay(UpdateBookingFinalRequest $request){
        $bookingId = $request->post('booking_id');
        $penalty = floatval($request->post('penalty', 0));
        $methodPayment = $request->post('method_payment');

        $typeIcon = "success";
        $title = "Se termino el hospedaje correctamente";
        $result = true;
        $resultCode = 200;

        $this->saveBookingStatusHostingCompleted($bookingId, $penalty, $methodPayment, $typeIcon, $title, $result, $resultCode);

        $request->session()->flash($typeIcon, $title);

//        return redirect('admin/booking/create')->with('success','Data has been added.');
        return redirect('admin/reception/index');
    }

    public function fSellingProducts(Request $request): \Illuminate\Http\JsonResponse
    {
//        $products = Product::getAllProductsDropBox();
        $categoriesAndProducts = Category::getCategoriesAndProductsDropBox();
        $booking = Booking::find($request->input('bookingId'));

        $paymentMethods = config('bookings.method_payment');

        $view = view('reception._partials._selling_products', [
            'booking' => $booking,
            'categoriesAndProducts' => $categoriesAndProducts,
            'paymentMethods' => $paymentMethods
        ])->render();

        return response()->json(['view'=>$view]);
    }

    public function saveSellingProducts(StoreReceiptPost $request): \Illuminate\Http\JsonResponse
    {
        $typeIcon = "success";
        $title = "Se realizo la Venta";
        $resultCode = 200;

        $booking = Booking::find($request->input('booking_id'));

        try{
            DB::beginTransaction();
            if(strcmp($request->input('payment'), 'now') == 0){
                $receipt = new Receipt();
                $receipt->nit_ruc_nif = $booking->customer->nit;
                $receipt->customer = $booking->customer->full_name;
                $receipt->issue_date = Carbon::now();
                ReceiptHelper::getTotal($receipt, $request->input('products'));
                $receipt->payment_status = "paid_extra";
                $receipt->payment_method = $request->input('payment_type');
                $receipt->booking_id = $booking->id;
                $receipt->customer_id = $booking->customer_id;
                $receipt->user_id = Auth::id();

                if($receipt->save()){
                    CashMovementHelper::createMovement(
                        $receipt->total,
                        CashMovement::TYPE_INCOME,
                        $receipt->payment_method,
                        'Venta frigobar | booking id: ' . $booking->id,
                        $receipt
                    );
                    foreach ($request->input('products') as $product){
                        $extraSale = new ExtraSales();
                        $extraSale->quantity = $product['amount'];
                        $extraSale->price = $product['price'];
                        $extraSale->discount = 0;
                        $extraSale->status = "PAID";
                        $extraSale->user_id = Auth::id();
                        $extraSale->booking_id = $booking->id;
                        $extraSale->receipt_id = $receipt->id;
                        $extraSale->product_id = $product['product_id'];

                        $extraSale->save();
                    }
                }
            } else {
                foreach ($request->input('products') as $product){
                    $extraSale = new ExtraSales();
                    $extraSale->quantity = $product['amount'];
                    $extraSale->price = $product['price'];
                    $extraSale->discount = 0;
                    $extraSale->user_id = Auth::id();
                    $extraSale->booking_id = $booking->id;
                    $extraSale->product_id = $product['product_id'];

                    $extraSale->save();
                }
            }
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la venta, pongase en contacto con el administrador: " . $e->getMessage();
            $resultCode = 422;
            DB::rollBack();
        }
        return response()->json(['message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    private function saveBookingStatusHostingCompleted($bookingId, $penalty, $methodPayment, &$typeIcon, &$title, &$result, &$resultCode){
        /** @var Booking $booking */
        $booking = Booking::find($bookingId);

        try{
            DB::beginTransaction();
            $booking->penalty = $penalty;
            $booking->final_payment = $booking->getTotalPayAttribute();
            $booking->final_payment_method = $methodPayment;

            // Actualizar checkout si sale antes
            $now = Carbon::now();
            if($now < $booking->checkout_date){
                $booking->checkout_date = $now;
            }

            $booking->save();

            $receipt = new Receipt();
            $receipt->nit_ruc_nif = $booking->customer->nit? $booking->customer->nit : '0';
            $receipt->customer = $booking->customer->full_name;
            $receipt->issue_date = Carbon::now();


            $receipt->subtotal = $booking->getExtraSalesNotPaidTotal() + $booking->final_payment;
            $receipt->tax = 0;
            $receipt->total = $receipt->subtotal - $receipt->tax;

            $receipt->payment_status = "paid";
            $receipt->payment_method = $methodPayment;
            $receipt->booking_id = $booking->id;
            $receipt->customer_id = $booking->customer_id;
            $receipt->user_id = Auth::id();

            if($receipt->save()){
                CashMovementHelper::createMovement(
                    $receipt->total,
                    CashMovement::TYPE_INCOME,
                    $receipt->payment_method,
                    'Termino de Hospedaje y Pago venta extra al registrar salida booking_id: ' . $booking->id,
                    $receipt // source
                );
                foreach ($booking->extraSales() as $extraSale){
                    if(strcmp($extraSale->status, ExtraSales::STATUS_NO_PAID) == 0){
                        $extraSale->status = "PAID";
                        $extraSale->save();
                    }
                }
            }

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $booking->id;
            $bookingStatus->name = BookingStatus::STATUS_HOSTING_COMPLETED;

            $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
            $bookingStatus->user_id = Auth::id();
            $bookingStatus->save();

            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la venta, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }
    }

    public function generateInvoice($id)
    {
        $receipt = Receipt::where('booking_id', $id)->where('payment_status', 'paid')->first();

        $pdf = Pdf::loadView('booking.pdfs.booking-invoice', compact('receipt'));
        return $pdf->download('factura.pdf');
    }

    public function generateInvoiceExtra($id)
    {
        $receipt = Receipt::where('id', $id)->where('payment_status', 'paid_extra')->first();

        $pdf = Pdf::loadView('booking.pdfs.booking-invoice-extra', compact('receipt'));
        return $pdf->download('factura-extra.pdf');
    }

    function aGetListHuesped(Request $request){
        $bookingId = $request->post('booking_id');

        /** @var Booking $booking */
        $booking = Booking::find($bookingId);

        $publicPath = public_path('data/countries.json');
        $currentData = [];

        if (file_exists($publicPath)) {
            $currentData = json_decode(file_get_contents($publicPath), true);
        }

        $huespedes = Huesped::where('booking_id', $bookingId)->orderBy('name')->get();

        $html = view('booking.partials._form_create_huesped', [
            'booking'=>$booking,
            'huespedes' => $huespedes,
            'countries' => $currentData

        ])->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}
