<?php

namespace App\Http\Livewire\CashFlow;

use App\Models\CashRegisterSession;
use Auth;
use Illuminate\Support\Carbon;
use Livewire\Component;

class CashRegisterManager extends Component
{
    // La sesión activa del usuario (si existe)
    public $activeSession;
    
    // Propiedad para el formulario de apertura
    public $initial_cash = 0;
    
    // Propiedades para el formulario de cierre
    public $counted_cash_at_close;
    public $closing_notes;
    
    // Propiedades para el resumen de cierre
    public $calculatedCash = 0;
    public $netMovements = 0;
    public $difference = 0;
    public $totalIncomes = 0;
    public $totalExpenses = 0;

    /**
     * Carga la sesión activa del usuario al montar el componente.
     */
    public function mount()
    {
        $this->loadActiveSession();
    }

    /**
     * Busca la sesión 'open' del usuario.
     */
    public function loadActiveSession()
    {
        $this->activeSession = CashRegisterSession::where('user_id', Auth::id())
                                                  ->where('status', 'open')
                                                  ->first();

        if($this->activeSession){
            // --- El Conteo (Lógica Central) ---
            
            // 1. Sumar todos los movimientos de esta sesión.
            // Asumimos que 'income' es positivo y 'expense' es negativo en 'amount'.
            $this->netMovements = $this->activeSession->cashMovements()->sum('amount');
            
            // 2. Calcular el total esperado en caja.
            $this->calculatedCash = $this->activeSession->initial_cash + $this->netMovements;

            // 3. Calcular la diferencia.
            $this->difference = $this->counted_cash_at_close - $this->calculatedCash;
            
            // 4. (Opcional) Totales para el reporte.
            $this->totalIncomes = $this->activeSession->cashMovements()->where('type', 'income')->sum('amount');
            $this->totalExpenses = $this->activeSession->cashMovements()->where('type', 'expense')->sum('amount'); // (será negativo)

            // --- Fin del Conteo ---
        }
    }

    /**
     * Acción: Abre una nueva sesión de caja.
     */
    public function openRegister()
    {
        $this->validate([
            'initial_cash' => 'required|numeric|min:0',
        ]);

        // Pre-condición: Asegurarse de que no haya otra sesión abierta.
        if ($this->activeSession) {
            session()->flash('error', 'Ya tienes una caja abierta.');
            return;
        }

        $this->activeSession = CashRegisterSession::create([
            'user_id'      => Auth::id(),
            'initial_cash' => $this->initial_cash,
            'opened_at'    => Carbon::now(),
            'status'       => 'open',
        ]);

        session()->flash('success', 'Caja abierta exitosamente con S/ ' . $this->initial_cash);
        $this->reset('initial_cash');

        // ¡MODIFICACIÓN! Emitir evento para notificar al modal wrapper que se cierre.
        $this->emit('cashSessionUpdated');

        return $this->redirect(request()->header('Referer'));
        
    }

    /**
     * Acción: Cierra la sesión de caja activa.
     * Aquí ocurre el "conteo de cierre de caja".
     */
    public function closeRegister()
    {
        $this->validate([
            'counted_cash_at_close' => 'required|numeric|min:0',
        ]);

        if (!$this->activeSession) {
            session()->flash('error', 'No hay ninguna caja abierta para cerrar.');
            return;
        }

        // 5. Actualizar la sesión en la DB.
        $this->activeSession->update([
            'closed_at'                  => Carbon::now(),
            'status'                     => 'closed',
            'calculated_cash_at_close'   => $this->calculatedCash,
            'counted_cash_at_close'      => $this->counted_cash_at_close,
            'difference'                 => $this->difference,
            'closing_notes'              => $this->closing_notes,
        ]);

        // Disparamos un evento para mostrar el modal de resumen
        $this->dispatchBrowserEvent('show-closing-summary-modal');

        // Reseteamos el estado del componente
        $this->activeSession = null;
        $this->reset(['counted_cash_at_close', 'closing_notes']);

        $this->emit('cashSessionUpdated');

        return $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.cash-flow.cash-register-manager');
    }
}
