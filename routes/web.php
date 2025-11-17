<?php

use App\Http\Controllers\CashMovementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffDepartment;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\RoomlevelController;
use App\Http\Controllers\HomeController;
use \App\Http\Controllers\AuthController;

use \App\Http\Controllers\ReceptionController;
use \App\Http\Controllers\RoomStatusController;

use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;
use App\Http\Controllers\FactoryController;
use \App\Http\Controllers\HuespedController;
use \App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class,'hotel']);
//Route::get('/hotel',[HomeController::class,'hotel']);
Route::get('/service/{id}',[HomeController::class,'service_detail']);
Route::get('page/about-us',[PageController::class,'about_us']);
Route::get('page/contact-us',[PageController::class,'contact_us']);

// Admin Login
Route::get('admin/login',[AdminController::class,'login']);
Route::post('admin/login',[AdminController::class,'check_login']);
Route::get('admin/logout',[AdminController::class,'logout']);

// Admin Dashboard
Route::get('admin',[AdminController::class,'dashboard']);

// Banner Routes
Route::get('admin/banner/{id}/delete',[BannerController::class,'destroy']);
Route::resource('admin/banner',BannerController::class);

// RoomType Routes
Route::get('admin/roomtype/{id}/delete',[RoomtypeController::class,'destroy']);
Route::resource('admin/roomtype',RoomtypeController::class);

// Room
Route::get('admin/rooms/{id}/delete',[RoomController::class,'destroy']);
Route::post('admin/rooms/get-room-status',[RoomController::class,'aGetRoomStatusById'])->name('admin.room.get_room_status');
Route::resource('admin/rooms',RoomController::class);

// Room Status
Route::post('admin/room-status/a-save-room-status',[RoomStatusController::class,'aSaveRoomStatus'])->name('admin.room-status.a_save_room_status');
Route::post('admin/room-status/a-close-room-status',[RoomStatusController::class,'aCloseRoomStatus'])->name('admin.room-status.a_close_room_status');
Route::post('admin/room-status/a-get-room-status',[RoomStatusController::class,'aGetRoomStatusById'])->name('admin.room-status.a_get_room_status');

// Customer
Route::get('admin/customer/a-get-form-customer',[CustomerController::class,'aGetFormCustomer'])->name("admin.customer.aGetFormCustomer");
Route::post('admin/customer/a-save-customer',[CustomerController::class,'aSaveCustomer'])->name("admin.customer.aSaveCustomer");
Route::get('admin/customer/{id}/delete',[CustomerController::class,'destroy']);
Route::post('admin/customer/a-get-customer',[CustomerController::class,'aGetCustomer'])->name('admin.customer.a_get_customer');
Route::resource('admin/customer',CustomerController::class);

// Delete Image
Route::get('admin/roomtypeimage/delete/{id}',[RoomtypeController::class,'destroy_image']);

// Department
Route::get('admin/department/{id}/delete',[StaffDepartment::class,'destroy']);
Route::resource('admin/department',StaffDepartment::class);

// Staff Payment
Route::get('admin/staff/payments/{id}',[StaffController::class,'all_payments']);
Route::get('admin/staff/payment/{id}/add',[StaffController::class,'add_payment']);
Route::post('admin/staff/payment/{id}',[StaffController::class,'save_payment']);
Route::get('admin/staff/payment/{id}/{staff_id}/delete',[StaffController::class,'delete_payment']);
// Staff CRUD
Route::get('admin/staff/{id}/delete',[StaffController::class,'destroy']);
Route::resource('admin/staff',StaffController::class);


// Booking
Route::get('admin/booking/a-get-events',[BookingController::class,'a_getEvents']);
Route::get('admin/booking/calendar',[BookingController::class,'calendar']);
Route::get('admin/booking/{id}/delete',[BookingController::class,'destroy']);
Route::get('admin/booking/available-rooms/{checkin_date}',[BookingController::class,'available_rooms']);
Route::get('admin/booking/invoice/{id}',[BookingController::class,'generateInvoice'])->name('admin.booking.invoice');
Route::get('admin/booking/invoice-extra/{id}',[BookingController::class,'generateInvoiceExtra'])->name('admin.booking.invoice.extra');
Route::get('admin/booking/get-rooms',[BookingController::class,'aGetRooms']);
Route::get('admin/booking/status-booking/{bookingId}',[BookingController::class,'statusBooking'])->name('admin.booking.statusBooking');
Route::post('admin/booking/terminate-stay',[BookingController::class,'terminateStay'])->name('admin.booking.terminate_stay');
Route::post('admin/booking/get-booking',[BookingController::class,'aGetBookingById'])->name('admin.booking.a_get_by_id');
Route::post('admin/booking/get-date-now',[BookingController::class,'aGetDateNow'])->name('admin.booking.a_get_date_now');
Route::post('admin/booking/get-modal-body-booking',[BookingController::class,'aGetBookingModalBody'])->name('admin.booking.a_get_booking_modal');
Route::post('admin/booking/get-list-huesped',[BookingController::class,'aGetListHuesped'])->name('admin.booking.a_get_list_huesped');
Route::post('admin/booking/a-update-booking-state-reservation-confirmed',[BookingController::class,'aUpdateBookingStateConfirmed'])->name('admin.booking.a_update_booking_state_confirmed');
Route::post('admin/booking/a-update-booking-state-reservation-not-confirmed',[BookingController::class,'aUpdateBookingStateNoConfirmed'])->name('admin.booking.a_update_booking_state_not_confirmed');
Route::post('admin/booking/a-update-booking-state-reservation-not-income',[BookingController::class,'aUpdateBookingStateNotIncome'])->name('admin.booking.a_update_booking_state_not_income');
Route::post('admin/booking/a-update-booking-state-income',[BookingController::class,'aUpdateBookingStateIncome'])->name('admin.booking.a_update_booking_state_income');
Route::post('admin/booking/f-selling-products',[BookingController::class,'fSellingProducts'])->name('admin.booking.fSellingProducts');
Route::post('admin/booking/save-selling-products',[BookingController::class,'saveSellingProducts'])->name('admin.booking.saveSellingProducts');
// Route::post('admin/booking/a-update-booking',[BookingController::class,'aUpdateBooking'])->name('admin.booking.a_update');
Route::resource('admin/booking',BookingController::class);

Route::get('login',[CustomerController::class,'login']);
Route::post('customer/login',[CustomerController::class,'customer_login']);
Route::get('register',[CustomerController::class,'register']);
Route::get('logout',[CustomerController::class,'logout']);
Route::post('customer/valid-customer',[CustomerController::class,'validCustomer'])->name('customer.a.create.validate.customer');
Route::post('customer/valid-booking',[CustomerController::class,'validBooking'])->name('customer.a.create.validate.booking');
Route::post('customer/valid-cost',[CustomerController::class,'validCost'])->name('customer.a.create.validate.cost');
Route::post('customer/a-update-booking',[CustomerController::class,'aUpdateBooking'])->name('customer.booking.a_update');
Route::post('customer/a-delete-booking',[CustomerController::class,'aDeleteBooking'])->name('customer.booking.a_delete');
Route::post('customer/a-search-person',[CustomerController::class,'aSearchPerson'])->name("customer.ajax-search-person");

Route::get('booking',[BookingController::class,'front_booking']);
Route::get('booking/success',[BookingController::class,'booking_payment_success']);
Route::get('booking/fail',[BookingController::class,'booking_payment_fail']);

// Service CRUD
Route::get('admin/service/{id}/delete',[ServiceController::class,'destroy']);
Route::resource('admin/service',ServiceController::class);

// Testimonial
Route::get('customer/add-testimonial',[HomeController::class,'add_testimonial']);
Route::post('customer/save-testimonial',[HomeController::class,'save_testimonial']);
Route::get('admin/testimonial/{id}/delete',[AdminController::class,'destroy_testimonial']);
Route::get('admin/testimonials',[AdminController::class,'testimonials']);
Route::post('save-contactus',[PageController::class,'save_contactus']);

Route::get('/test-vue', function(){
    return \Inertia\Inertia::render('Home');
});

// RoomLevel Routes
//Route::get('admin/roomlevel/{id}/delete',[RoomlevelController::class,'destroy']);
Route::resource('admin/roomlevel',RoomlevelController::class);


Route::get('/hlogin', function () {
    return view('Auth/login');
})->name('auth.hlogin');

Route::post('Auth/check', [AuthController::class,'check'])->name('Auth.check');
Route::post('Auth/store', [AuthController::class,'store'])->name('Auth.store');
Route::get('Auth/logout', [AuthController::class,'logout'])->name('Auth.logout');

//Admin
Route::get('Admin/dashboard', [AuthController::class,'dashboard'])->name('Admin.dashboard');

// Reception
Route::get('admin/reception/index',[ReceptionController::class,'index'])->name('admin.reception.index');
Route::get('admin/reception/process-room/{roomId}',[ReceptionController::class,'processRoom'])->name('admin.reception.process-room');
Route::get('admin/reception/a-get-level-rooms-tab/{roomLevelId}/{datetime}',[ReceptionController::class,'aGetRoomByLevelId'])
    ->name('admin.reception.a_get_level_room_tab');
Route::post('admin/reception/get-menu-room-status',[ReceptionController::class,'aGetMenuRoomStatus'])->name('admin.reception.getMenuRoomStatus');
Route::post('admin/reception/save-room-busy',[ReceptionController::class,'saveRoomBusy'])->name('admin.reception.saveRoomBusy');

Route::group(['middleware'=>['AuthCheck']], function(){
    Route::get('Admin/dashboard', [AuthController::class,'dashboard'])->name('Admin.dashboard');

    Route::get('Auth/login', [AuthController::class,'login'])->name('Auth.login');
    Route::get('Auth/register', [AuthController::class,'register'])->name('Auth.register');
});

Route::group(['middleware' => 'auth'], function () {
    // Category
    Route::get('admin/product/a-get-category/{id}', [CategoryController::class, 'aGetFormCategory']);
    Route::get('admin/product/get-category/{id}', [CategoryController::class, 'getCategory']);
    Route::post('admin/product/update-category', [CategoryController::class, 'aUpdateCategory'])->name('admin.product.category.aUpdateCategory');
    Route::resource('admin/product/category',CategoryController::class);
    // Factory
    Route::get('admin/product/factory/a-get-factory/{id?}', [FactoryController::class, 'aGetFormFactory']);
    Route::get('admin/product/factory/get-factory/{id}', [FactoryController::class, 'getFactory']);
    Route::post('admin/product/factory/update-factory', [FactoryController::class, 'aUpdateFactory'])->name('admin.product.factory.aUpdateFactory');
    Route::resource('admin/product/factory',FactoryController::class);
    // Product
    Route::post('admin/product/a-get-product', [ProductController::class, 'aGetProduct'])->name('admin.product.aGetProduct');
    Route::post('admin/product/a-delete-filename', [ProductController::class, 'aDeleteFilename'])->name('admin.product.adeletefilename');
    Route::resource('admin/product',ProductController::class);

    // RoomType Routes
    Route::get('admin/a-get-room-type/{id}',[RoomtypeController::class,'getRoomType'])->name('admin.room_type.a_get_room_type');
    Route::post('admin/a-delete-room-type',[RoomtypeController::class,'aDeleteRoomType'])->name('admin.room_type.a_delete_room_type');

    // Huespedes routes
    Route::post('admin/huesped/a-save',[HuespedController::class,'aStore'])->name('admin.huesped.asave');
    Route::post('admin/huesped/a-delete',[HuespedController::class,'aDelete'])->name('admin.huesped.adelete');

    // Reports routes
    Route::get('admin/report/consolidated-by-day/{date?}', [ReportController::class, 'consolidatedByDay'])->name('admin.report.consolidated_by_day');
    Route::get('admin/report/consolidated-by-range', [ReportController::class, 'consolidatedByRange'])->name('admin.report.consolidated_by_range');
});

Route::get('admin/cash-movements/index', [CashMovementController::class,'index'])->name('admin.cash-movements.home');