<?php

namespace App\Services;

use App\Models\CashMovement;
use App\Models\MiscellaneousTransaction;
use App\Models\CashRegisterSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    /**
     * Crea una nueva transacción miscelánea y su movimiento de caja asociado.
     *
     * @param array $data Los datos validados del componente Livewire.
     * @throws \Exception Si la caja no está abierta.
     * @return MiscellaneousTransaction
     */
    public function createMiscellaneousTransaction(array $data)
    {
        // 1. (REGLA DE NEGOCIO) Validar que la caja esté abierta
        $activeSession = CashRegisterSession::where('user_id', Auth::id())
                                            ->where('status', 'open')
                                            ->first();

        if (!$activeSession) {
            // Arroja una excepción que el componente Livewire capturará
            throw new \Exception("Caja cerrada. No se pueden registrar movimientos.");
        }

        // 2. Usar una transacción de DB para asegurar atomicidad
        return DB::transaction(function () use ($data, $activeSession) {
            
            // 3. Crear la transacción miscelánea (la 'causa')
            $transaction = MiscellaneousTransaction::create([
                'category' => $data['category'],
                'notes' => $data['notes'],
                'invoice_reference' => $data['invoice_reference'] ?? null,
                'authorized_by_user_id' => Auth::id(),
            ]);

            Log::info('Miscellaneous Transaction created', ['id' => $transaction->id]);

            // 4. Crear el movimiento de caja (el 'efecto') usando la relación polimórfica
            $transaction->cashMovement()->create([
                'amount' => $data['type'] === 'expense' ? -abs($data['amount']) : abs($data['amount']),
                'type' => $data['type'], // 'income' o 'expense'
                'payment_method' => $data['payment_method'],
                'description' => $data['notes'], // Usamos las notas como descripción
                'user_id' => Auth::id(),
                'cash_register_session_id' => $activeSession->id, // ¡Vinculado a la sesión!
            ]);

            Log::info('Cash Movement created for transaction', ['transaction_id' => $transaction->id]);
            
            return $transaction;
        });
    }

    /**
     * Actualiza una transacción miscelánea y su movimiento de caja.
     */
    public function updateMiscellaneousTransaction(MiscellaneousTransaction $transaction, array $data)
    {
        return DB::transaction(function () use ($transaction, $data) {
            
            // 1. Actualizar la transacción
            $transaction->update([
                'category' => $data['category'],
                'notes' => $data['notes'],
                'invoice_reference' => $data['invoice_reference'] ?? null,
            ]);

            // 2. Actualizar el movimiento de caja asociado
            // Usamos update() en la relación
            $transaction->cashMovement()->update([
                'amount' => $data['type'] === 'expense' ? -abs($data['amount']) : abs($data['amount']),
                'type' => $data['type'],
                'payment_method' => $data['payment_method'],
                'description' => $data['notes'],
            ]);

            return $transaction;
        });
    }

    /**
     * Elimina una transacción miscelánea y su movimiento de caja.
     */
    public function deleteMiscellaneousTransaction(MiscellaneousTransaction $transaction)
    {
        return DB::transaction(function () use ($transaction) {
            // Buena práctica: Cargar la relación antes de eliminar
            $transaction->load('cashMovement');
            
            // 1. Elimina primero el movimiento de caja
            if ($transaction->cashMovement) {
                $transaction->cashMovement->delete();
            }
            
            // 2. Luego elimina la transacción
            return $transaction->delete();
        });
    }
}