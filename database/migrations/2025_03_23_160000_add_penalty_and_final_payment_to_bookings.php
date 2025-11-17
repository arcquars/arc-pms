<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyAndFinalPaymentToBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->double('penalty', 10, 2)->nullable();
            $table->double('final_payment', 10, 2)->nullable();
            $table->string('final_payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('penalty');
            $table->dropColumn('final_payment');
            $table->dropColumn('final_payment_method');
        });
    }
}
