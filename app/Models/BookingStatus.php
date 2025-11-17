<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    protected $table = 'booking_status';

    const COLOR_AVAILABLE = 'AVAILABLE';
    const STATUS_RESERVATION_NOT_CONFIRMED = "reservation_not_confirmed";
    const STATUS_RESERVATION_CONFIRMED = "reservation_confirmed";
    const STATUS_INCOME = "income";
    const STATUS_NO_INCOME = "no_income";
    const STATUS_HOSTING_COMPLETED = "hosting_completed";

    function booking(){
        return $this->belongsTo(Booking::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}
