<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $id = $this->input('product');

        $name = 'max:200|unique:products';
        if(isset($id)){
            $name = 'max:200|unique:products,code,'.$id.',id';
        }

        return [
            'name' => 'required',
            'code' => $name,
            'description' => 'nullable|string|max:500',
            'price_reference' => 'required|numeric|min:0',
            'price_minimum' => 'numeric|between:0,'.request('price_reference'),
            'coste' => 'nullable|numeric|min:0',
            'measure' => 'required',
            'category' => 'required',
            'factory' => 'required',
            'image_product' => 'image|mimes:jpeg,jpg,bmp,png|max:30000'
        ];
    }
}
