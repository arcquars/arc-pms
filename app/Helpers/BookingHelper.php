<?php

namespace App\Helpers;

use App\Models\BookingStatus;
use Illuminate\Support\Facades\Log;

class BookingHelper
{

    public static function getBookingStatusValid($status): array
    {
        Log::info("Pdm:::: " . $status);
        $bookingStatus = [];
        switch ($status){
            case BookingStatus::STATUS_RESERVATION_CONFIRMED:
                $bookingStatus[BookingStatus::STATUS_RESERVATION_CONFIRMED] = __('hotel-manager.' . BookingStatus::STATUS_RESERVATION_CONFIRMED);
                $bookingStatus[BookingStatus::STATUS_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_INCOME);
//                $bookingStatus[BookingStatus::STATUS_NO_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_NO_INCOME);
//                $bookingStatus[BookingStatus::STATUS_HOSTING_COMPLETED] = __('hotel-manager.' . BookingStatus::STATUS_HOSTING_COMPLETED);
                break;
            case BookingStatus::STATUS_INCOME:
                $bookingStatus[BookingStatus::STATUS_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_INCOME);
//                $bookingStatus[BookingStatus::STATUS_NO_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_NO_INCOME);
//                $bookingStatus[BookingStatus::STATUS_HOSTING_COMPLETED] = __('hotel-manager.' . BookingStatus::STATUS_HOSTING_COMPLETED);
                break;
            case BookingStatus::STATUS_NO_INCOME:
                $bookingStatus[BookingStatus::STATUS_NO_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_NO_INCOME);
//                $bookingStatus[BookingStatus::STATUS_HOSTING_COMPLETED] = __('hotel-manager.' . BookingStatus::STATUS_HOSTING_COMPLETED);
                break;
            case BookingStatus::STATUS_HOSTING_COMPLETED:
                $bookingStatus[BookingStatus::STATUS_HOSTING_COMPLETED] = __('hotel-manager.' . BookingStatus::STATUS_HOSTING_COMPLETED);
                break;
            default:
                $bookingStatus[BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED] = __('hotel-manager.' . BookingStatus::STATUS_RESERVATION_NOT_CONFIRMED);
                $bookingStatus[BookingStatus::STATUS_RESERVATION_CONFIRMED] = __('hotel-manager.' . BookingStatus::STATUS_RESERVATION_CONFIRMED);
//                $bookingStatus[BookingStatus::STATUS_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_INCOME);
//                $bookingStatus[BookingStatus::STATUS_NO_INCOME] = __('hotel-manager.' . BookingStatus::STATUS_NO_INCOME);
//                $bookingStatus[BookingStatus::STATUS_HOSTING_COMPLETED] = __('hotel-manager.' . BookingStatus::STATUS_HOSTING_COMPLETED);
        }
        return $bookingStatus;
    }
}
