<?php

namespace App\Http\Requests;

use App\Models\BookingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateBookingRequest extends FormRequest
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
        $customId = $this->input('customer.id');
        $personId = $this->input('customer.client.id');
        $bookingId = $this->input('booking.id');
        $ruleForward = 'nullable|numeric|min:1';
        if(strcmp($this->input('booking.status'), BookingStatus::STATUS_RESERVATION_CONFIRMED) == 0){
            $ruleForward = 'required|numeric|min:1';
        }
//        dd($bookingId);
        return [
            // Person and Customer
            'customer.client.first_name' => 'required|min:3|max:120',
            'customer.client.last_name_paternal' => 'required|min:3|max:120',
            'customer.client.last_name_maternal' => 'nullable|min:3|max:120',
            'customer.client.document_type' => 'required',
            'customer.client.document' => 'required|min:2|max:120|unique:people,document,'.$personId,
            'customer.client.document_complement' => 'nullable|min:1|max:10',
            'customer.nit' => 'nullable|min:3|max:20|unique:customers,nit,' . $customId,
            'customer.nit_name' => 'exclude_if:customer.nit,null|min:3|max:20',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string|min:2|max:45',
            // Booking
            'booking.room' => 'required',
            'booking.checkin_date' => 'required|date|before:booking.checkout_date|booking_busy:booking.checkout_date,booking.room,'. $bookingId,
            'booking.checkout_date' => 'required|date|after:booking.checkin_date',
            'booking.total_adults' => 'required|integer|min:1',
            'booking.total_children' => 'required|integer|min:0',
            // Cost
            'cost.discount_type' => 'required',
            'cost.discount' => 'nullable|numeric|min:0',
            'cost.extra_charge' => 'nullable|numeric|min:0',
            'cost.forward' => $ruleForward,
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
