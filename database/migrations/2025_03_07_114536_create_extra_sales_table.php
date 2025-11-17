<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_sales', function (Blueprint $table) {
            $table->id();

            $table->integer('quantity'); // Cantidad del servicio o producto
            $table->decimal('price', 10, 2); // Precio unitario del servicio o producto
            $table->decimal('discount', 10, 2); // Precio unitario del servicio o producto
            $table->string('status')->default('NO_PAID');

            $table->timestamps(); // Crea las columnas `created_at` y `updated_at`

            $table->bigInteger('user_id');

            // Definir la clave foránea
            $table->unsignedBigInteger('booking_id'); // Clave foránea
            $table->foreign('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('cascade'); // Eliminar ventas si se elimina la reserva

            $table->unsignedBigInteger('product_id')->nullable(); // Clave foránea
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null');

            $table->bigInteger('receipt_id')->nullable(); // Clave foránea


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_sales');
    }
}
