<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Booking extends Model
{
    use HasFactory;

    const FORWARD_METHOD_PAYMENT_EFFECTIVE = "Effective";
    const FORWARD_METHOD_PAYMENT_TRANSFER = "Transfer";
    const FORWARD_METHOD_PAYMENT_CARD = "Card";

    protected $appends = ['checkin_date_input_format', 'checkout_date_input_format', 'reservation_days'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'checkin_date' => 'datetime:Y-m-d H:i:s',
        'checkout_date' => 'datetime:Y-m-d H:i:s',
    ];

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function room(){
        return $this->belongsTo(Room::class);
    }

    function bookingStatus(){
        return $this->hasMany(BookingStatus::class)->orderBy('created_at', "desc");
    }

    function extraSales(){
        return $this->hasMany(ExtraSales::class);
    }

    function receipts(){
        return $this->hasMany(Receipt::class);
    }

    function bookingLastStatus(){
        return $this->bookingStatus()->first();
    }

    function bookingFirstStatus(){
        $lastBooking = null;
        foreach ($this->bookingStatus as $bs){
            $lastBooking = $bs;
        }
        return $lastBooking;
    }

    function getLastStatusAttribute(){
        return $this->bookingStatus()->first();
    }

    function getCheckinDateInputFormatAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->checkin_date)->format('Y-m-d\TH:i');
    }

    function getCheckoutDateInputFormatAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->checkout_date)->format('Y-m-d\TH:i');
    }

    function getReservationDaysAttribute(){
        $checkin = Carbon::createFromFormat('Y-m-d H:i:s', $this->checkin_date);
        /** @var Carbon $checkout */
        $checkout = Carbon::createFromFormat('Y-m-d H:i:s', $this->checkout_date);
        return ceil($checkout->floatDiffInDays($checkin, true));
    }

    function bookingRoomStatus(){
        return $this->hasMany(BookingRoomStatus::class)->orderBy('status_date', "desc");
    }

    function bookingRoomStatusLast(){
        return $this->bookingRoomStatus()->first();
    }

    public function getTotalPayAttribute(){
        $totalPay = 0;
        if($this->discount_type == 1){
            $totalPay = $this->cost - ($this->cost * $this->discount / 100);
        } else {
            $totalPay = $this->cost - $this->discount;
        }

        $totalPay = $totalPay + $this->extra_charge - $this->forward + $this->penalty;

        return round($totalPay, 2);
    }

    public function getCalculatedCostAttribute(){
        $calculatedCost = 0;
        if($this->discount_type == 1){
            $calculatedCost = $this->cost - ($this->cost * $this->discount / 100);
        } else {
            $calculatedCost = $this->cost - $this->extra_charge;
        }

        return round($calculatedCost, 2);
    }

    public function remainingHostingTime(){
        $now = Carbon::now();
        $diferencia = $this->checkout_date->diff($now); // ✅ Calcula la diferencia

        $bookingStatus = $this->bookingLastStatus();
        if(strcmp($bookingStatus->name, BookingStatus::STATUS_HOSTING_COMPLETED) == 0 || strcmp($bookingStatus->name, BookingStatus::STATUS_NO_INCOME) == 0){
            $resultado = "<p class='text-success m-0'>Terminado</p>";
        } else {
            if($diferencia->invert == 0){
                $resultado = "<p class='text-danger m-0'>Sobrepaso su tiempo de salida</p>";
            } else {
                $resultado = "<p class='text-success m-0'>{$diferencia->d} días, {$diferencia->h} horas, {$diferencia->i} minutos</p>";
            }
        }
        return $resultado;

    }

    public function getExtraSalesNotPaidTotal(){
        $total = 0;
        $extraSales = $this->extraSales;
//        dd($extraSales);
        foreach ($extraSales as $extraSale){
            if(strcmp($extraSale->status, ExtraSales::STATUS_NO_PAID) == 0){
                $total += $extraSale->getSubTotalAttribute();
            }
        }

        return $total;
    }
    static function roomIsFreeWithInOut($roomId, $dateIn, $dateOut, $bookingId=null){
        $arooms = 0;
        if(!$dateOut){
            return false;
        }
        $checkin = Carbon::createFromFormat('Y-m-d\TH:i', $dateIn);
        $checkout = Carbon::createFromFormat('Y-m-d\TH:i', $dateOut);
        Log::debug("Pdm 2216 1:::: " . $checkin . " || " . $roomId);

        if($bookingId == null){
            Log::debug("Pdm 2216 2:::: " . $checkin . " || " . $roomId);
            $query = "b.room_id= ? AND (b.checkin_date between ? and ? OR b.checkout_date between ? and ?) AND b.active=1 AND bs.name not like 'no_income'";

            $builder = DB::table('bookings as b')
                ->join('booking_status as bs', 'b.id', '=', 'bs.booking_id')
                ->orderBy('bs.id', 'desc')
                ->groupBy('b.id')
                ->having('bs.name', 'not like', 'no_income')
                ->whereRaw($query, [$roomId, $checkin, $checkout, $checkin, $checkout]);

            $arooms1 = $builder->get();
            $arooms = count($arooms1);

            $sql = $builder->toSql();
            $bindings = $builder->getBindings();
            foreach ($bindings as $binding) {
                $value = is_string($binding) ? "'$binding'" : $binding;
                $sql = preg_replace('/\?/', $value, $sql, 1);
            }
        } else {
            $query = "b.room_id= ? AND (b.checkin_date between ? and ? OR b.checkout_date between ? and ?) AND b.active=1 AND b.id <> ? AND bs.name not like 'no_income'";
//            $arooms=DB::table('bookings')->whereRaw($query, [$roomId, $dateIn, $dateOut, $dateIn, $dateOut, $bookingId])->count();
            $builder=DB::table('bookings as b')
                ->join('booking_status as bs', 'b.id', '=', 'bs.booking_id')
                ->orderBy('bs.id', 'desc')
                ->groupBy('b.id')
                ->having('bs.name', 'not like', 'no_income')
                ->whereRaw($query, [$roomId, $dateIn, $dateOut, $dateIn, $dateOut, $bookingId]);

            $arooms1 = $builder->get();

            $sql = $builder->toSql();
            $bindings = $builder->getBindings();
            foreach ($bindings as $binding) {
                $value = is_string($binding) ? "'$binding'" : $binding;
                $sql = preg_replace('/\?/', $value, $sql, 1);
            }
            $arooms = count($arooms1);
        }

//        Log::info("Pdm Booking::roomIsFreeWithInOut :: " . $roomId . " || " . $dateIn . " || " . $dateOut);

        if($arooms>0)
            return false;
        return true;
    }

    public function countExtraSalePaidExtra(){
        return Receipt::where('booking_id', $this->id)->where('payment_status', 'like', Receipt::PAYMENT_STATUS_PAID_EXTRA)->count();
    }

    public function getBookingStatusReservation(){
        return $this->bookingStatus()->where('name', 'like', BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED)->first();
    }
}
