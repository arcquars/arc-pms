<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscellaneousTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "category",
        "notes",
        "invoice_reference",
        "authorized_by_user_id",
    ];

    public function cashMovement()
    {
        // El 'source' es el nombre usado en la migración de cash_movements
        return $this->morphOne(CashMovement::class, 'source');
    }

    public function authorizedByUser(){
        return $this->belongsTo(User::class,'authorized_by_user_id');
    }

    public function canModifyOpenSession(): bool{
        $status = $this->cashMovement->cashRegisterSession->status;
        if(strcmp($status, CashRegisterSession::STATUS_OPEN) == 0){
            return true;
        }
        return false;
    }
}
