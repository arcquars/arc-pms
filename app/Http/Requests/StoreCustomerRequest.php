<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreCustomerRequest extends FormRequest
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
        Log::info("vvv:: " . $this->input('customer.id'));
        $customId = $this->input('customer.id');
        $personId = $this->input('customer.client.id');

        $rulePersonDocument = 'required|min:2|max:120|unique:people,document';
        if($personId){
            $rulePersonDocument = 'required|min:2|max:120|unique:people,document,'.$personId;
        }
        $ruleCustomerNit = 'nullable|min:3|max:20|unique:customers,nit';
        if($customId){
            $ruleCustomerNit = 'nullable|min:3|max:20|unique:customers,nit,' . $customId;
        }
        return [
            'customer.client.first_name' => 'required|min:3|max:120',
            'customer.client.last_name_paternal' => 'required|min:3|max:120',
            'customer.client.last_name_maternal' => 'nullable|min:3|max:120',
            'customer.client.document_type' => 'required',
            'customer.client.document' => $rulePersonDocument,
            'customer.client.document_complement' => 'nullable|min:1|max:10',
            'customer.nit' => $ruleCustomerNit,
            'customer.nit_name' => 'exclude_if:customer.nit,null|min:3|max:20',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string|min:2|max:45',
        ];
    }
}
