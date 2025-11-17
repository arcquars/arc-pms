<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\MiscellaneousTransaction;
use App\Services\TransactionService;
use Auth;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MiscellaneousTransactionsManager extends Component
{
    use WithPagination;

    // --- PROPIEDADES DE FILTRO (NUEVAS) ---
    public $filterStartDate;
    public $filterEndDate;
    public $filterType = ''; // Puede ser 'income', 'expense' o ''
    public $filterByUser = false; // Bandera para filtrar por el usuario logueado
    // ----------------------------------------

    // Propiedades para controlar los modales de Bootstrap
    public $showModal = false;
    public $showConfirmDeleteModal = false;

    // Propiedades para el formulario
    public $transactionId = null;
    public $state = []; // Usamos un array 'state' para el binding del formulario
    
    // Propiedades de soporte
    public $paymentMethods = [Booking::FORWARD_METHOD_PAYMENT_EFFECTIVE, Booking::FORWARD_METHOD_PAYMENT_TRANSFER, Booking::FORWARD_METHOD_PAYMENT_CARD];
    public $transactionToDeleteId = null;
    
    // Inyección del Servicio de Transacciones
    protected $transactionService;

    // Reglas de validación
    protected $rules = [
        'state.category' => 'required|string|max:100',
        'state.notes' => 'required|string|max:255',
        'state.invoice_reference' => 'nullable|string|max:100',
        'state.amount' => 'required|numeric|min:0.01',
        'state.type' => 'required|in:income,expense',
        'state.payment_method' => 'required|string|max:50',
    ];

    /**
     * Inyecta el servicio al instanciar el componente.
     * (Livewire 2 usa boot() o el constructor para inyección de servicios)
     */
    public function boot(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Inicializa el estado del formulario.
     */
    public function mount()
    {
        $this->initializeState();

        // Inicializa las fechas de filtro a la semana actual por defecto (Buena práctica UX)
        $this->filterStartDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->filterEndDate = Carbon::now()->endOfWeek()->format('Y-m-d');
    }

    /**
     * Resetea el array $state a sus valores por defecto.
     */
    private function initializeState()
    {
        $this->state = [
            'category' => '',
            'notes' => '',
            'invoice_reference' => '',
            'amount' => '',
            'type' => 'expense', // Por defecto es un egreso
            'payment_method' => 'Effective',
        ];
    }

    //--- ACCIONES DE MODAL ---

    /**
     * Abre el modal para crear una nueva transacción.
     */
    public function create()
    {
        $this->resetErrorBag(); // Limpia errores de validación previos
        $this->initializeState();
        $this->transactionId = null;
        $this->showModal = true;
    }

    /**
     * Abre el modal para editar una transacción existente.
     */
    public function edit($id)
    {
        $this->resetErrorBag();
        $this->transactionId = $id;

        try {
            $transaction = MiscellaneousTransaction::with('cashMovement')->findOrFail($id);
            
            // Rellena el estado con los datos existentes
            $this->state = [
                'category' => $transaction->category,
                'notes' => $transaction->notes,
                'invoice_reference' => $transaction->invoice_reference,
                'amount' => abs($transaction->cashMovement->amount),
                'type' => $transaction->cashMovement->type,
                'payment_method' => $transaction->cashMovement->payment_method,
            ];

            $this->showModal = true;

        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo cargar la transacción para editar.');
            Log::error('Error loading transaction for edit: ' . $e->getMessage());
        }
    }

    /**
     * Cierra el modal de creación/edición.
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->initializeState();
        $this->resetErrorBag();
    }

    //--- LÓGICA CRUD (Conectada al Servicio) ---

    /**
     * Guarda la transacción (Crea o Actualiza).
     */
    public function save()
    {
        // Valida los datos en $state
        $data = $this->validate();

        try {
            if ($this->transactionId) {
                // Actualizar
                $transaction = MiscellaneousTransaction::find($this->transactionId);
                $this->transactionService->updateMiscellaneousTransaction($transaction, $data['state']);
                session()->flash('success', 'Transacción actualizada exitosamente.');
            } else {
                // Crear
                $this->transactionService->createMiscellaneousTransaction($data['state']);
                session()->flash('success', 'Transacción registrada exitosamente.');
            }

            $this->closeModal(); // Cierra el modal al guardar

        } catch (\Exception $e) {
            // Captura errores (ej: "Caja cerrada")
            Log::error('Error saving transaction: ' . $e->getMessage());
            // Muestra el error en el modal (UI/UX)
            $this->addError('general', 'Error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el modal de confirmación de eliminación.
     */
    public function confirmDelete($id)
    {
        $this->transactionToDeleteId = $id;
        $this->showConfirmDeleteModal = true;
    }

    /**
     * Ejecuta la eliminación.
     */
    public function deleteTransaction()
    {
        try {
            $transaction = MiscellaneousTransaction::findOrFail($this->transactionToDeleteId);
            $this->transactionService->deleteMiscellaneousTransaction($transaction);
            session()->flash('success', 'Transacción eliminada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error deleting transaction: ' . $e->getMessage());
            session()->flash('error', 'No se pudo eliminar la transacción.');
        }

        $this->showConfirmDeleteModal = false;
        $this->transactionToDeleteId = null;
    }


    /**
     * Renderiza la vista.
     */
    public function render()
    {
        $query = MiscellaneousTransaction::with('cashMovement', 'authorizedByUser')
            ->orderBy('created_at', 'desc');

        // --- LÓGICA DE FILTROS (NUEVA) ---

        // 1. Filtrar por rango de fecha
        if ($this->filterStartDate) {
            $query->whereDate('created_at', '>=', $this->filterStartDate);
        }
        if ($this->filterEndDate) {
            $query->whereDate('created_at', '<=', $this->filterEndDate);
        }

        // 2. Filtrar por tipo (Ingreso/Egreso)
        if ($this->filterType) {
            // Unimos con cashMovement para filtrar por el tipo de movimiento
            $query->whereHas('cashMovement', function ($q) {
                $q->where('type', $this->filterType);
            });
        }

        // 3. Filtrar por usuario logueado (quién registró el movimiento)
        if ($this->filterByUser) {
            $query->whereHas('cashMovement', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }
        
        // --- FIN LÓGICA DE FILTROS ---

        $transactions = $query->paginate(10); 

        return view('livewire.miscellaneous-transactions-manager', [
            'transactions' => $transactions,
            // Pasamos el usuario actual para mostrar en la tabla (si se desea)
            'currentUserId' => Auth::id() 
        ]);
    }
}