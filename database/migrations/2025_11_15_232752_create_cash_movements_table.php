<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();

            // Monto de la transacción. Positivo para ingresos, negativo para egresos.
            $table->decimal('amount', 10, 2); 

            // Tipo de movimiento: 'income' (ingreso) o 'expense' (egreso).
            $table->enum('type', ['income', 'expense']);

            // Método de pago (Efectivo, Transferencia, Tarjeta, etc.)
            // Usamos las constantes de tu modelo Booking como referencia.
            $table->string('payment_method', 50);

            // Descripción o concepto del movimiento.
            $table->string('description', 255);

            // Clave foránea polimórfica.
            // 'source_id' será el ID del Booking, ExtraSale o MiscellaneousTransaction.
            // 'source_type' será el nombre del Modelo (ej: 'App\Models\Booking').
            $table->morphs('source');

            // Usuario que registra el movimiento (ej: recepcionista).
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            // Fecha en que ocurrió la transacción (puede ser diferente a created_at).
            $table->timestamp('transaction_date')->useCurrent();
            
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
        Schema::dropIfExists('cash_movements');
    }
}
