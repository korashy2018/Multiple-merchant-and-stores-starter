<?php

namespace App\Http\Requests\API\Merchants;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'ar.name'        => 'required|min:2|max:30',
            'en.name'        => 'required|min:2|max:30',
            'ar.description' => 'required|min:2|max:200',
            'en.description' => 'required|min:2|max:200',
            'price'          => 'required|numeric|gt:0'
        ];
    }
}
