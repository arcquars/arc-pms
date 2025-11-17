<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatusAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'assigned_to',
        'action_date',
        'user_id',
        'room_status_id'
    ];

}
