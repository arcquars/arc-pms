<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'detail'];

    function rooms(){
        return $this->hasMany(Room::class,'room_level_id');
    }
}
