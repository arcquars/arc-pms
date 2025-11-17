<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuespedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huespedes', function (Blueprint $table) {
            $table->id();

            $table->string('name', 200);
            $table->string('document', 100);
            $table->string('country', 200);

            $table->foreignId('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huespedes');
    }
}
