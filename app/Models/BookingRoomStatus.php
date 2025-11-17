<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRoomStatus extends Model
{
    use HasFactory;

    const STATUS_RESERVATION = 'RESERVATION';
    const STATUS_RESERVATION_COLOR = '#146DE5';
    const STATUS_AVAILABLE = 'AVAILABLE';
    const STATUS_AVAILABLE_COLOR = '#28a745';

}
