<?php
namespace App\Helpers;

use App\Models\CashMovement;
use App\Models\CashRegisterSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CashMovementHelper
{
    /**
     * @throws \Exception Si no hay caja abierta para el usuario.
     */
    public static function createMovement(
        float $amount, 
        string $type, 
        string $paymentMethod, 
        string $description, 
        Model $source
    ) {
        // 1. Encontrar la sesión activa del usuario.
        $activeSession = CashRegisterSession::where('user_id', Auth::id())
                                            ->where('status', 'open')
                                            ->first();

        // 2. Aplicar la regla de negocio.
        if (!$activeSession) {
            throw new \Exception("No se puede registrar el movimiento. El usuario no tiene una caja abierta.");
        }

        // 3. Crear el movimiento y asociarlo a la sesión.
        return CashMovement::create([
            'amount'                   => $amount,
            'type'                     => $type,
            'payment_method'           => $paymentMethod,
            'description'              => $description,
            'source_id'                => $source->id,
            'source_type'              => get_class($source),
            'user_id'                  => Auth::id(),
            'cash_register_session_id' => $activeSession->id, // ¡La conexión clave!
        ]);
    }
}