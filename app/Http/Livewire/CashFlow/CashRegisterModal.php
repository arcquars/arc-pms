<?php

namespace App\Http\Livewire\CashFlow;

use Livewire\Component;

class CashRegisterModal extends Component
{
    public $showModal = false;

    /**
     * Listeners de eventos globales.
     * 'open-cash-register-modal' -> Disparado por un botón en cualquier lugar (ej: Navbar).
     * 'cashSessionUpdated' -> Disparado por el componente hijo (CashRegisterManager)
     * cuando abre o cierra la caja exitosamente.
     */
    protected $listeners = [
        'open-cash-register-modal' => 'open',
        'close-cash-register-modal' => 'close',
        'cashSessionUpdated' => 'close' // Cierra el modal automáticamente al éxito.
    ];

    /**
     * Muestra el modal.
     */
    public function open()
    {
        $this->showModal = true;
    }

    /**
     * Oculta el modal.
     */
    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.cash-flow.cash-register-modal');
    }
}
