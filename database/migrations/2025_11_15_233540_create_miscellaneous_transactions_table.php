<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiscellaneousTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miscellaneous_transactions', function (Blueprint $table) {
            $table->id();

            // Categoría del movimiento (ej: 'Refund', 'Charge').
            $table->string('category', 100)->nullable();
            
            // Notas adicionales sobre la transacción.
            $table->text('notes')->nullable();
            
            // Referencia a una factura o recibo externo, si existe.
            $table->string('invoice_reference', 100)->nullable();
            
            // Usuario que autorizó o solicitó esta transacción.
            $table->foreignId('authorized_by_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

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
        Schema::dropIfExists('miscellaneous_transactions');
    }
}
