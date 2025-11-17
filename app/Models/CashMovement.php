<?php

namespace App\Models;

// ... (otros imports)
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashMovement extends Model
{
    use HasFactory;

    const TYPE_INCOME = "income";
    const TYPE_OUTCOME = "outcome";
    
    protected $fillable = [
        'amount',
        'type',
        'payment_method',
        'description',
        'source_id',
        'source_type',
        'user_id',
        'cash_register_session_id',
        
    ];
    
    /**
     * La sesión de caja a la que pertenece este movimiento.
     */
    public function cashRegisterSession()
    {
        return $this->belongsTo(CashRegisterSession::class);
    }

    /**
     * La fuente polimórfica (Booking, ExtraSale, MiscellaneousTransaction).
     */
    public function source()
    {
        return $this->morphTo();
    }
}