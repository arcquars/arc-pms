<?php

namespace App\Http\Requests;

use App\Models\RoomStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreRoomStatusCloseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roomStatus = RoomStatus::find($this->input('room_status_id'));

        return [
            'room_status_id' => 'required',
            'assigned_to' => 'required',
            'action_date' => 'required|date|after:' . $roomStatus->start_date->format('Y-m-d H:i'),
        ];
    }
}
