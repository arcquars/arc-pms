<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Validator::extend('bookingBusy', function ($attribute, $value, $parameters, $validator) {
            $checkoutDate = Request::input($parameters[0]);
            $roomId = Request::input($parameters[1]);
            $bookingId = null;
            if(isset($parameters[2])){
                $bookingId = $parameters[2];
            }
            return Booking::roomIsFreeWithInOut($roomId, $value, $checkoutDate, $bookingId);
        });

        Validator::extend('bookingCost', function ($attribute, $value, $parameters, $validator) {
            $checkoutDate = Request::input($parameters[0]);
            $roomId = Request::input($parameters[1]);
            return Booking::roomIsFreeWithInOut($roomId, $value, $checkoutDate);
        });
    }
}
