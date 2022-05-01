<?php

namespace App\Http\Requests\API\Customers;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "cart"            => 'required|array',
            "cart.*.id"       => 'required|exists:products,id',
            "cart.*.quantity" => 'required|integer|gt:0',
            "cart.*.price"    => 'required|numeric|gt:0'
        ];
    }
}
