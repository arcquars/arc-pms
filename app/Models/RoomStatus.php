<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    use HasFactory;

    const STATUS_AVAILABLE = 'AVAILABLE';
    const STATUS_AVAILABLE_COLOR = '#28a745';
    const STATUS_AVAILABLE_ICON = 'fas fa-bed';

    const STATUS_CLEANING = "CLEANING";
    const STATUS_MAINTENANCE = "MAINTENANCE";
    const STATUS_BLOOKED = "BLOOKED";
    const STATUS_RESERVATION = "RESERVATION";
    const STATUS_BUSY = "BUSY";
    const STATUS_BUSY_CHECKOUT_BACKLOG = "BUSY_CHECKOUT_BACKLOG";

    protected $casts = [
        'start_date' => 'datetime:Y-m-d H:i',
        'end_date' => 'datetime:Y-m-d H:i',
    ];

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function statusBg(){
        $color = "#28a745";
        if($this->name){
            switch ($this->name){
                case RoomStatus::STATUS_BLOOKED:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_BLOOKED];
                    break;
                case RoomStatus::STATUS_AVAILABLE:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_AVAILABLE];
                    break;
                case RoomStatus::STATUS_RESERVATION:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_RESERVATION];
                    break;
                case RoomStatus::STATUS_BUSY:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_BUSY];
                    break;
                case RoomStatus::STATUS_BUSY_CHECKOUT_BACKLOG:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_BUSY_CHECKOUT_BACKLOG];
                    break;
                case RoomStatus::STATUS_CLEANING:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_CLEANING];
                    break;
                case RoomStatus::STATUS_MAINTENANCE:
                    $color = config('bookings.state_colors')[RoomStatus::STATUS_MAINTENANCE];
                    break;
            }
        }

        return $color;
    }
}
