<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashRegisterSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_register_sessions', function (Blueprint $table) {
            $table->id();

            // Usuario que abrió esta sesión de caja.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Estado de la sesión: 'open' o 'closed'.
            $table->enum('status', ['open', 'closed'])->default('open');

            // Hora exacta en que el usuario abrió la caja.
            $table->timestamp('opened_at')->useCurrent();
            
            // Hora exacta en que el usuario cerró la caja (es nulo mientras está abierta).
            $table->timestamp('closed_at')->nullable();

            // Monto con el que el usuario *inició* la caja (ej: $100 de fondo).
            $table->decimal('initial_cash', 10, 2)->default(0);

            // --- Columnas de Cierre (se llenan al cerrar) ---

            // Monto que el *sistema* calculó (initial_cash + movimientos).
            $table->decimal('calculated_cash_at_close', 10, 2)->nullable();
            
            // Monto que el *usuario* contó físicamente.
            $table->decimal('counted_cash_at_close', 10, 2)->nullable();
            
            // Diferencia (sobrante o faltante).
            $table->decimal('difference', 10, 2)->nullable();
            
            // Notas del usuario al cerrar (ej: "Faltaron $0.50").
            $table->text('closing_notes')->nullable();
            
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
        Schema::dropIfExists('cash_register_sessions');
    }
}
