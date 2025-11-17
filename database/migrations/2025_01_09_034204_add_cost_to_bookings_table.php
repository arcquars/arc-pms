<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('discount_type')->default(1);
            $table->double('discount', 10, 2)->default(0);
            $table->double('extra_charge', 10, 2)->default(0);
            $table->double('forward', 10, 2)->default(0);
            $table->double('cost', 10, 2)->default(0);
            $table->text('comments')->nullable();
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
            $table->dropColumn('discount_type');
            $table->dropColumn('discount');
            $table->dropColumn('extra_charge');
            $table->dropColumn('forward');
            $table->dropColumn('cost');
            $table->dropColumn('comments');
        });
    }
}
