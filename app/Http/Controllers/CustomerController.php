<?php

namespace App\Http\Controllers;

use App\Helpers\CashMovementHelper;
use App\Http\Requests\StoreAcustomerRequest;
use App\Http\Requests\StoreBookingCostRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\CashMovement;
use App\Models\Person;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Customer::all();
        return view('customer.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
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
            'full_name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'mobile'=>'required',
        ]);

        if($request->hasFile('photo')){
            $imgPath=$request->file('photo')->store('public/imgs');
        }else{
            $imgPath=null;
        }

        $data=new Customer;
        $data->full_name=$request->full_name;
        $data->email=$request->email;
        $data->password=sha1($request->password);
        $data->mobile=$request->mobile;
        $data->address=$request->address;
//        $data->photo=$imgPath;
        $data->photo= 'imgs/'.basename($imgPath);
        $data->save();

        $ref=$request->ref;
        if($ref=='front'){
            return redirect('register')->with('success','Data has been saved.');
        }

        return redirect('admin/customer/create')->with('success','Data has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Customer::find($id);
        return view('customer.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Customer::find($id);
        return view('customer.edit',['data'=>$data]);
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
        $request->validate([
            'full_name'=>'required',
            'email'=>'required|email',
            'mobile'=>'required',
        ]);

        if($request->hasFile('photo')){
            $imgPath=$request->file('photo')->store('public/imgs');
        }else{
            $imgPath=$request->prev_photo;
        }

        $data=Customer::find($id);
        $data->full_name=$request->full_name;
        $data->email=$request->email;
        $data->mobile=$request->mobile;
        $data->address=$request->address;
//        $data->photo=$imgPath;
        $data->photo= 'imgs/'.basename($imgPath);
        $data->save();

        return redirect('admin/customer/'.$id.'/edit')->with('success','Data has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Customer::where('id',$id)->delete();
       return redirect('admin/customer')->with('success','Data has been deleted.');
    }

    // Login
    function login(){
        return view('frontlogin');
    }

    // Check Login
    function customer_login(Request $request){
        $email=$request->email;
        $pwd=sha1($request->password);
        $detail=Customer::where(['email'=>$email,'password'=>$pwd])->count();
        if($detail>0){
            $detail=Customer::where(['email'=>$email,'password'=>$pwd])->get();
            session(['customerlogin'=>true,'data'=>$detail]);
            return redirect('/');
        }else{
            return redirect('login')->with('error','Invalid email/password!!');
        }
    }

    // register
    function register(){
        return view('register');
    }

    // Logout
    function logout(){
        session()->forget(['customerlogin','data']);
        return redirect('login');
    }

    function validCustomer(StoreCustomerRequest $request): \Illuminate\Http\JsonResponse
    {
        if($request->has('booking.checkin_date') && strcmp($request->input('booking.checkin_date'), '') != 0){
            $checkin = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('booking.checkin_date'));
        } else {
            $checkin = Carbon::now();
        }

        $checkInTime = config('bookings.check-in-time');
        $checkOutTime = config('bookings.check-out-time');
        $checkinString = $checkin->setHour($checkInTime['hour'])->setMinute($checkInTime['minute'])->format('Y-m-d\TH:i');
        $checkoutString = $checkin->addDays(1)->setHour($checkOutTime['hour'])->setMinute($checkOutTime['minute'])->format('Y-m-d\TH:i');
        return response()->json(['result' => 1, 'checkin' => $checkinString, 'checkout' => $checkoutString]);
    }

    function validBooking(StoreBookingRequest $request): \Illuminate\Http\JsonResponse
    {
        $checkin_date = $request->input('booking.checkin_date');
        $checkout_date = $request->input('booking.checkout_date');
        /** @var Carbon $checkin */
        $checkin = Carbon::createFromFormat('Y-m-d\TH:i', $checkin_date);
        $checkout = Carbon::createFromFormat('Y-m-d\TH:i', $checkout_date);
        $reservationDays = ceil($checkin->floatDiffInDays($checkout, true));
        /** @var Room $room */
        $room = Room::find(1);
        return response()->json(['result' => 1, 'roomType' => $room->Roomtype, 'reservationDays' => $reservationDays]);
    }

//    function validCost(Request $request): \Illuminate\Http\JsonResponse
    function validCost(StoreBookingCostRequest $request): \Illuminate\Http\JsonResponse
    {
        $typeIcon = "success";
        $title = "Se realizo la reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();
            $person = new Person();
            if($request->input('customer.client.id')){
                $person = Person::find($request->input('customer.client.id'));
            }

            $person->fill($request->input('customer')['client']);
            $person->save();

            $customer = new Customer();
            if($request->input('customer.id')){
                $customer = Customer::find($request->input('customer.id'));
            }
            $customer->fill($request->input('customer'));
            $customer->full_name = $person->first_name . " " . $person->last_name_paternal;
            $customer->mobile = $request->input('customer')['phone'];
            $customer->person_id = $person->id;
            $customer->save();

            $booking = new Booking();
            $booking->room_id = $request->input('booking.room');
            $booking->customer_id = $customer->id;
            $booking->checkin_date = $request->input('booking')['checkin_date'];
            $booking->checkout_date = $request->input('booking')['checkout_date'];
            $booking->ref = 'admin';
            $booking->total_adults = $request->input('booking')['total_adults'];
            $booking->total_children = $request->input('booking.total_children', 0);
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
            $booking->cost = $request->filled('cost.total_pay')? $request->input('cost_total', 0) : 0;
            $booking->comments = $request->input('booking.comments', "");
            $booking->send_email = $request->filled('booking.send_email')? $request->input('booking.send_email', 0) : 0;
            $booking->save();

            if($booking->forward != null){
                CashMovementHelper::createMovement(
                    $booking->forward, // amount
                    CashMovement::TYPE_INCOME, // type
                    $booking->forward_method_payment, // payment_method
                    'Adelanto Reserva : ' . $booking->comments, // description
                    $booking // source
                );
            }

            $bookingStatus = new BookingStatus();
            $bookingStatus->booking_id = $booking->id;
            if($booking->forward > 0){
                $bookingStatus->name = BookingStatus::STATUS_RESERVATION_CONFIRMED;
            } else {
                $bookingStatus->name = BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED;
            }
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

    function aUpdateBooking(UpdateBookingRequest $request){
        $typeIcon = "success";
        $title = "Se actualizo la reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();
            $person = new Person();
            if($request->input('customer.client.id')){
                $person = Person::find($request->input('customer.client.id'));
            }

            $person->fill($request->input('customer')['client']);
            $person->save();

            $customer = new Customer();
            if($request->input('customer.id')){
                $customer = Customer::find($request->input('customer.id'));
            }
            $customer->fill($request->input('customer'));
            $customer->full_name = $person->first_name . " " . $person->last_name_paternal;
            $customer->mobile = $request->input('customer')['phone'];
            $customer->person_id = $person->id;
            $customer->save();

            $booking = Booking::find($request->input('booking.id'));
            $booking->room_id = $request->input('booking.room');
            $booking->customer_id = $customer->id;
            $booking->checkin_date = $request->input('booking')['checkin_date'];
            $booking->checkout_date = $request->input('booking')['checkout_date'];
            $booking->ref = 'admin';
            $booking->total_adults = $request->input('booking')['total_adults'];
            $booking->total_children = $request->input('booking.total_children', 0);
            $booking->discount_type = $request->input('cost.discount_type');
            $booking->discount = $request->filled('cost.discount')? $request->input('cost.discount', 0) : 0;
            $booking->extra_charge = $request->filled('cost.extra_charge')? $request->input('cost.extra_charge', 0) : 0;
            $forwardNew = $request->input('cost.forward');

//            if(($booking->forward > 0 && $forwardNew != $booking->forward) || !isset($booking->forward)){
            if($forwardNew != $booking->forward || !isset($booking->forward)){
                $booking->forward = $request->filled('cost.forward')? $request->input('cost.forward', 0) : 0;
                $booking->forward_method_payment = $request->input('booking.forward_method_payment', "Effective");
                $booking->forward_payment_user = Auth::id();
            }

            $booking->cost = $request->filled('cost.total_pay')? $request->input('cost.total_pay', 0) : 0;
            $booking->comments = $request->input('booking.comments', "");
            $booking->send_email = $request->filled('booking.send_email')? $request->input('booking.send_email', 0) : 0;
            $booking->save();

            $bookingStatusLast = $booking->getLastStatusAttribute();
            if(strcmp($bookingStatusLast->name, $request->input('booking.status')) != 0){
                $bookingStatus = new BookingStatus();
                $bookingStatus->booking_id = $booking->id;
                $bookingStatus->name = $request->input('booking.status');
                $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
                $bookingStatus->user_id = Auth::id();
                $bookingStatus->save();
            } else {
                if(strcmp($bookingStatusLast->name, BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED) == 0 && $booking->forward > 0){
                    $bookingStatus = new BookingStatus();
                    $bookingStatus->booking_id = $booking->id;
                    $bookingStatus->name = BookingStatus::STATUS_RESERVATION_CONFIRMED;
                    $bookingStatus->color = config('bookings.booking_status_colors')[$bookingStatus->name];
                    $bookingStatus->user_id = Auth::id();
                    $bookingStatus->save();
                }
            }

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

    function aDeleteBooking(Request $request){
        $bookingId = $request->input('bookingId');
        $typeIcon = "success";
        $title = "Se Elimino la reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();
//            BookingStatus::where('booking_id', $bookingId)->delete();
//            Booking::find($bookingId)->delete();
            $booking = Booking::find($bookingId);
            $booking->active = 0;
            $booking->save();

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

    function aSearchPerson(Request $request){
        $term = trim($request->post('q'));

        if (empty($term)) {
            return response()->json([]);
        }
        $query = Customer::query()
            ->latest()
            ->select(['id', 'full_name', 'email', 'nit', 'nit_name']);
        $words = explode(' ', $term);
        foreach ($words as $term1) {

            $word = Str::slug($term1); // <== clean user input

            $word = str_replace(['%', '_'], ['\\%', '\\_'], $word);

            $searchTerm = '%'.$word.'%';

            $query->has('person')->where(function (Builder $subQuery) use ($searchTerm) {
                $subQuery->where('full_name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('nit', 'like', $searchTerm)
                    ->orWhere('nit_name', 'like', $searchTerm);
            });
        }

        $customers = $query->limit(5)->get();
        $formatted_customers = [];
        foreach ($customers as $customer) {
            $formatted_customers[] = [
                'id' => $customer->id,
//                'text' => $customer->full_name . " - " . $customer->nit . " - " . $customer->nit_name . " - " . $customer->email
                'text' => $customer->full_name_nit
            ];
        }

        return response()->json($formatted_customers);
    }

    function aGetCustomer(Request $request){
        $customerId = $request->post('customer');
        $customer = Customer::find($customerId);
        return response()->json(['customer' => $customer, "person" => $customer->person]);
    }

    public function aGetFormCustomer(){
        $documentTypes = config('bookings.document_type');
        $view = view('customer.partials._form_customer', [
            'documentTypes' => $documentTypes
        ])->render();

        return response()->json(['view'=>$view]);
    }

    public function aSaveCustomer(StoreAcustomerRequest $request){
        $typeIcon = "success";
        $title = "Se actualizo la reserva";
        $result = true;
        $resultCode = 200;

        try{
            DB::beginTransaction();
            $person = new Person();

            $person->fill($request->input('customer')['person']);
            if($person->save()){
                $customer = new Customer();
                $customer->fill($request->input('customer'));
                $customer->full_name = $person->first_name . " " . $person->last_name_paternal;
                $customer->mobile = $request->input('customer')['phone'];
                $customer->person_id = $person->id;
                $customer->save();
            }
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

}
