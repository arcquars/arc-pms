<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Room extends Model
{
    use HasFactory;

    function roomType(){
        return $this->belongsTo(RoomType::class,'room_type_id');
    }

    function roomLevel(){
        return $this->belongsTo(RoomLevel::class,'room_level_id');
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    /**
     * @param Carbon $date
     * @return mixed
     */
    function getBookingByDate($date){
        $query = Booking::where('room_id', $this->id)
            ->where('active', 1)
            ->where('checkin_date', '<=', $date)
            ->where('checkout_date', '>=', $date);


//        if($this->id == 1){
//            $sql = $query->toSql();
//            $bindings = $query->getBindings();
//            Log::info('Consulta SQL para la búsqueda de Booking:', [
//                'query' => $sql,
//                'bindings' => $bindings,
//            ]);
//        }

        $booking = $query->first();

        if($booking == null){
            $dateCopy = $date->copy();
            $dateCopy->hour = 14;
            $dateCopy->minute = 00;
            $dateCopy->second = 01;
//            $dateAux = $dateCopy->format('Y-m-d H:i:s');
            /** @var Booking $booking */
            $booking = Booking::where('room_id', $this->id)
                ->where('active', 1)
                ->where('checkout_date', '<=', $dateCopy)
                ->orderBy('checkout_date', 'desc')->first();
            if($booking){
                Log::info("Room id:: " . $this->id . " | name:: " . $this->title . " | bookingId:: " . $booking->id);
                $bookingStatus = $booking->getLastStatusAttribute();
                if(isset($bookingStatus->name) && (strcmp($bookingStatus->name, BookingStatus::STATUS_HOSTING_COMPLETED) == 0 ||
                        strcmp($bookingStatus->name, BookingStatus::STATUS_NO_INCOME) == 0)){
                    $booking = null;
                }
            }
        }
        return $booking;
    }

    public function roomStatuses(){
        return $this->hasMany(RoomStatus::class)->orderBy('created_at', 'asc');
    }

    public function roomStatus(){
        return $this->hasOne(RoomStatus::class)->latestOfMany();
    }

    /**
     * @return Booking|null
     */
    public function getBookingOpen(){
        $bookings = $this->booking;
        /** @var Booking $booking */
        foreach ($bookings as $booking){
            if($booking->bookingLastStatus() != null){
                if(strcmp($booking->bookingLastStatus()->name, BookingStatus::STATUS_HOSTING_COMPLETED) != 0 && strcmp($booking->bookingLastStatus()->name, BookingStatus::STATUS_NO_INCOME) != 0){
                    return $booking;
                }
            }

        }
        return null;
    }

}
