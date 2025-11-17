<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryPost extends FormRequest
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
        $id = $this->input('category');

        $rule = 'required|unique:categories';
        if(isset($id)){
            $rule = 'required|unique:categories,name,'.$id.',id';
        }

        return [
            'name' => $rule,
        ];
    }

}
