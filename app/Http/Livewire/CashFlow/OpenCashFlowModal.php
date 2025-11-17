<?php

namespace App\Http\Livewire\CashFlow;

use Livewire\Component;

class OpenCashFlowModal extends Component
{
    public $showModal = false;

    public $initialBalance;
    /**
     * Define los listeners para los eventos de Livewire.
     * Escuchamos 'open-modal' para abrir el modal y 'close-modal' para cerrarlo.
     *
     * @var array
     */
    protected $listeners = [
        'open-modal'  => 'open',
        'close-modal' => 'close',
    ];

    protected $rules = [

        'initialBalance' => 'required'
    ];

    /**
     * Abre el modal cambiando el estado de la propiedad.
     *
     * @return void
     */
    public function open()
    {
        $this->initialBalance = null;
        $this->showModal = true;
    }

    /**
     * Cierra el modal cambiando el estado de la propiedad.
     *
     * @return void
     */
    public function close()
    {
        // Se establece la propiedad a false para ocultar el modal.
        $this->showModal = false;
    }

    public function saveCashFlow(){
        $validatedDate = $this->validate();
        $this->close();
    }

    /**
     * Método de renderizado del componente Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.cash-flow.open-cash-flow-modal');
    }
}
