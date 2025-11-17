<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingCostRequest extends FormRequest
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
            'cost.discount_type' => 'required',
            'cost.discount' => 'nullable|numeric|min:0',
            'cost.extra_charge' => 'nullable|numeric|min:0',
            'cost.forward' => 'nullable|numeric|min:0',
            'booking.forward_method_payment' => 'exclude_if:cost.forward,null|required',
//            'booking.forward_method_payment' => 'required',
            'cost.total_pay' => 'nullable|numeric|min:0',
            'booking.comments' => 'nullable|string|max:255',
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
