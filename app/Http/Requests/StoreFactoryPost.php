<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactoryPost extends FormRequest
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
        $id = $this->post('factory');

        $rule = 'required|unique:factories,name';
        if(isset($id)){
            $rule = 'required|unique:factories,name,'.$id.',id';
        }

        return [
            'name' => $rule,
            'origin' => 'max:300'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre no puede estar vacio.',
            'name.unique' => 'Nombre de la fabrica ya esta registrado.',
            'origin.max' => 'Caximo de caracteres 300'
            ];
    }
}
