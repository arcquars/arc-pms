<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomStatusActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_status_actions', function (Blueprint $table) {
            $table->id();

            $table->string('action');
            $table->bigInteger('assigned_to');
            $table->dateTime('action_date');
            $table->boolean('deleted')->default(false);

            $table->bigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('room_status_actions', function (Blueprint $table) {
            $table->unsignedBigInteger('room_status_id');
            $table->foreign('room_status_id')->references('id')->on('room_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_status_actions');
    }
}
