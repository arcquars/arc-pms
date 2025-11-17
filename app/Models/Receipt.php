<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    const PAYMENT_STATUS_PAID = "paid";
    const PAYMENT_STATUS_PAID_EXTRA = "paid_extra";

    protected $fillable = [
        'receipt_number', 'nit_ruc_nif', 'customer', 'issue_date', 'subtotal', 'tax', 'total', 'user_id',
        'payment_method', 'payment_status', 'notes', 'invoice_id', 'customer_id', 'booking_id'
    ];

    function booking(): \Illuminate\Database\Eloquent\Relations\BelongsTo{
        return $this->belongsTo(Booking::class);
    }

    // Relación con la tabla `extra_sales`
    public function extraSales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExtraSales::class);
    }
}
