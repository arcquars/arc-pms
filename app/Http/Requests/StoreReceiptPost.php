<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptPost extends FormRequest
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
            'booking_id' => 'required',
            'products' => 'required|array',
            'products.*.amount' => 'required|numeric|min:0|max:80',
            'products.*.price' => 'required|numeric|gte:products.*.price_minimum|lte:products.*.price_reference',
            'payment' => 'required|string',
            'payment_type' => 'required_if:payment,now',
        ];
    }

    public function messages()
    {
        return [
            'products.*.amount.max' => 'El campo cantidad no debe ser mayor a :max',
            'payment_type.required_if' => 'El campo Metodo de Pago es obligatorio cuando el campo PAGO es AHORA.'
        ];
    }
}
