<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id(); // Identificador único del recibo
            $table->string('receipt_number')->unique()->nullable(); // Número único del recibo
            $table->string('nit_ruc_nif', 45);
            $table->string('customer', 250);

            $table->date('issue_date'); // Fecha de emisión del recibo
            $table->decimal('subtotal', 10, 2); // Subtotal antes de impuestos
            $table->decimal('tax', 10, 2); // Impuestos aplicados
            $table->decimal('total', 10, 2); // Total a pagar
            $table->enum('payment_method', ['Effective', 'Transfer', 'Card'])->nullable(); // Método de pago
            $table->enum('payment_status', ['pending', 'paid', 'paid_extra', 'cancelled'])->default('pending'); // Estado del pago
            $table->text('notes')->nullable(); // Notas adicionales (opcional)
            $table->bigInteger('invoice_id')->nullable();
            $table->timestamps(); // Fechas de creación y actualización

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('set null');

            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')
                ->references('id')
                ->on('bookings')
                ->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
