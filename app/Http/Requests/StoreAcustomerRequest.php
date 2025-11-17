<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreAcustomerRequest extends FormRequest
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
            'customer.person.first_name' => 'required|min:3|max:120',
            'customer.person.last_name_paternal' => 'required|min:3|max:120',
            'customer.person.last_name_maternal' => 'nullable|min:3|max:120',
            'customer.person.document_type' => 'required',
            'customer.person.document' => 'required|min:2|max:120|unique:people,document',
            'customer.person.document_complement' => 'nullable|min:1|max:10',
            'customer.nit' => 'nullable|min:3|max:20|unique:customers,nit',
            'customer.nit_name' => 'exclude_if:customer.nit,null|min:3|max:20',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string|min:2|max:45',
        ];
    }
}
