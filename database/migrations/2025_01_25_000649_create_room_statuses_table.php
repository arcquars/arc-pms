<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('active')->default(1);

            $table->timestamps();
        });

        Schema::table('room_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_statuses');
    }
}
