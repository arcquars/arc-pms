<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegisterSession extends Model
{
    use HasFactory;

    const STATUS_CLOSED = "closed";
    const STATUS_OPEN = "open";
    protected $fillable = [
        'user_id',
        'status',
        'opened_at',
        'closed_at',
        'initial_cash',
        'calculated_cash_at_close',
        'counted_cash_at_close',
        'difference',
        'closing_notes',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * El usuario propietario de esta sesión.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Todos los movimientos de caja que ocurrieron *durante* esta sesión.
     */
    public function cashMovements()
    {
        return $this->hasMany(CashMovement::class);
    }
}