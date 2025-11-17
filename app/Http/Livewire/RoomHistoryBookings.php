<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class RoomHistoryBookings extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /** @var Room */
    public $room;

    public $dateStart, $dateEnd, $textSearch;

    protected $rules = [
        'dateStart' => 'nullable|date|required_with:dateEnd',
        'dateEnd' => 'nullable|date|required_with:dateStart|after:dateStart',
        'textSearch' => 'nullable|string|max:100',
    ];

    public function mount($roomId)
    {
        $this->room = Room::find($roomId);
    }

    public function search()
    {
        $this->validate();
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['dateStart', 'dateEnd', 'textSearch']);
        $this->resetPage();
    }
//    public function search(){
//        $this->validate();
//
//        $query = Booking::query()->latest();
//
//        if ($this->dateStart) {
//            $query->whereDate('created_at', '>=', $this->dateStart);
//        }
//
//        if ($this->dateEnd) {
//            $query->whereDate('created_at', '<=', $this->dateEnd);
//        }
//
//        $this->bookings = $query->orderBy('checkin_date')->paginate(4);
//    }

    public function render()
    {
        $query = Booking::query();

        $query->where('room_id', $this->room->id);
        if(!empty($this->textSearch)){
            $query->whereHas('customer', function($q){
                $q->where(function($subQuery) {
                    $subQuery->where('full_name', 'like', '%' . $this->textSearch . '%')
                        ->orWhere('nit', 'like', '%' . $this->textSearch . '%');
                });
            });
        }
        if ($this->dateStart) {
            $query->whereDate('created_at', '>=', $this->dateStart);
        }

        if ($this->dateEnd) {
            $query->whereDate('created_at', '<=', $this->dateEnd);
        }

        $bookings = $query->orderBy('checkin_date', 'desc')->paginate(4);

        return view('livewire.room-history-bookings',
        [
            'bookings' => $bookings
        ]);
    }
}
