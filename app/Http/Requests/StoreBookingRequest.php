<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
        return [
            'booking.room' => 'required',
            'booking.checkin_date' => 'required|date|before:booking.checkout_date|booking_busy:booking.checkout_date,booking.room',
            'booking.checkout_date' => 'required|date|after:booking.checkin_date',
            'booking.total_adults' => 'required|integer|min:1',
            'booking.total_children' => 'required|integer|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'booking.checkin_date.booking_busy' => 'La habitacion esta ocupada',
        ];
    }
}
