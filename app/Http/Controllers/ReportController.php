<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consolidatedByDay($date = null)
    {
        $date = $date ?? Carbon::today()->toDateString();

        $checkins = Booking::whereDate('checkin_date', $date)->count();
        $checkouts = Booking::whereDate('checkout_date', $date)->count();

        $totalReservations = Booking::whereDate('checkin_date', '<=', $date)
            ->whereDate('checkout_date', '>', $date)
            ->count();
//
//        $totalIncome = Booking::whereDate('checkin_date', '<=', $date)
//            ->whereDate('checkout_date', '>', $date)
//            ->sum('total_amount');
//
//        $byRoomType = Booking::with('room')
//            ->whereDate('check_in_date', '<=', $date)
//            ->whereDate('check_out_date', '>', $date)
//            ->get()
//            ->groupBy( ($res) => $res->room->type)
//            ->map(fn ($group) => $group->count());

        return view(
            'reports.consolidated_day',
            compact('date', 'checkins', 'checkouts',
                'totalReservations'
// 'totalIncome', 'byRoomType'
            )
        );
    }

    public function consolidatedByRange(Request $request)
    {
        $dateInitial = $request->has('date_initial')? $request->input('date_initial') : Carbon::now()->subDays(2)->hours(0)->minutes(1)->format('Y-m-d\TH:i');
        $dateEnd = $request->has('date_end')? $request->input('date_end') : Carbon::now()->format('Y-m-d\TH:i');

        Log::info("eee1: " . $dateInitial);
//
//        $totalReservations = Booking::whereDate('checkin_date', '<=', $date)
//            ->whereDate('checkout_date', '>', $date)
//            ->count();

        return view(
            'reports.consolidated-range', compact('dateInitial', 'dateEnd')
        );
    }
}
