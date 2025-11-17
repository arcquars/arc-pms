<?php

namespace App\Helpers;

use App\Models\Receipt;
use Carbon\Carbon;

class ReceiptHelper
{
    public static function getTotal(Receipt &$receipt, $products)
    {
        $total = 0;
        foreach ($products as $product){
            $total += $product['price'] * $product['amount'];
        }
        $receipt->subtotal = $total;
        $receipt->tax = 0;
        $receipt->total = $total - $receipt->tax;
    }

    public static function getDayDiff($checkin_date, $checkout_date){
        $checkin = Carbon::createFromFormat('Y-m-d\TH:i', $checkin_date);
        /** @var Carbon $checkout */
        $checkout = Carbon::createFromFormat('Y-m-d\TH:i', $checkout_date);
        return ceil($checkout->floatDiffInDays($checkin));
    }

    public static function entryInterval(Carbon $checkin){
        $status = "";
        $now = Carbon::now();

        $result = $now->diffInMinutes($checkin, false);

        if($result >= 0){
            if($result <= 10){
                $status = "<br><small>(Menos de 10 min para ingreso)</small>";
            }
        } else {
            $status = "<br><small class='text-danger'><b>(Ingreso con retraso)</b></small>";
        }
        return $status;

    }
}
