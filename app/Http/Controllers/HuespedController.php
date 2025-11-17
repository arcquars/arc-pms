<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Huesped;
use Illuminate\Http\Request;

class HuespedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function aStore(Request $request)
    {
        $bookingId = $request->post('booking_id');

        $countHuespedes = Huesped::where('booking_id', $bookingId)->count();
        /** @var Booking $booking */
        $booking = Booking::find($bookingId);

        if($countHuespedes >= intval($booking->total_adults)){
            return response()->json([
                'success' => false,
            ]);
        }

        Huesped::create($request->all());

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

    public function aDelete(Request $request)
    {
        $huespedId = $request->post('huesped_id');

        /** @var Huesped $huesped */
        $huesped = Huesped::find($huespedId);
        $bookingId = $huesped->booking_id;
        $huesped->delete();
        $booking = Booking::find($bookingId);

        $publicPath = public_path('data/countries.json');
        $currentData = [];

        $huespedes = Huesped::where('booking_id', $bookingId)->orderBy('name')->get();

        if (file_exists($publicPath)) {
            $currentData = json_decode(file_get_contents($publicPath), true);
        }

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
