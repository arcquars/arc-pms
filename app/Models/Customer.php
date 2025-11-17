<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'mobile',
        'nit',
        'nit_name',
        'send_email',
        ];

    function bookings(){
        return $this->hasMany(Booking::class);
    }

    function person(){
        return $this->belongsTo(Person::class);
    }

    public function getFullNameNitAttribute(){
        return $this->full_name . " - " . $this->nit . " - " . $this->nit_name . " - " . $this->email;
    }

    public function getFullNameNitNameAttribute(){
        return $this->full_name . " (" . $this->nit . " - " . $this->nit_name . ")";
    }

}
