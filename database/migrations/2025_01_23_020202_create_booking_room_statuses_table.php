<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRoomStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_room_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name', 200);
            $table->string('color', 100);
            $table->dateTime('status_date')->nullable();
            $table->bigInteger('user_id')->nullable();

            $table->timestamps();
        });

        Schema::table('booking_room_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_room_statuses');
    }
}
