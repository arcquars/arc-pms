<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCashRegisterSessionIdToCashMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_movements', function (Blueprint $table) {
            // Clave foránea que vincula el movimiento a la sesión de caja.
            $table->foreignId('cash_register_session_id')
                  ->nullable() // Puede ser nulo si hay movimientos "administrativos".
                  ->after('user_id')
                  ->constrained('cash_register_sessions')
                  ->onDelete('set null'); // No borrar el movimiento si se borra la sesión.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_movements', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cash_register_session_id');
        });
    }
}
