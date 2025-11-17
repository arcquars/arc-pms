<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreRoomStatusRequest extends FormRequest
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
//        Log::info("vvv:: " . $this->input('customer.id'));
//        $customId = $this->input('customer.id');
//        $personId = $this->input('customer.client.id');

        return [
            'roomId' => 'required',
            'room-status-name' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after_or_equal:start_date'
//            'end_date' => 'required|date|after_or_equal:'.Carbon::now()->addDays(3)->format('Y-m-d H:i'),

        ];
    }
}
