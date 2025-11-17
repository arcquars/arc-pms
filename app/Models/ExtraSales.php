<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraSales extends Model
{
    use HasFactory;

    const STATUS_PAID = "PAID";
    const STATUS_NO_PAID = "NO_PAID";

    protected $fillable = ['quantity', 'price', 'discount', 'status', 'user_id', 'booking_id', 'receipt_id', 'product_id'];

    // Relación con la tabla `products`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con la tabla `receipts`
    public function receipt(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function getSubTotalAttribute(){
        $subTotal = ($this->quantity * $this->price) - $this->discount;

        return round($subTotal, 2);
    }
}
