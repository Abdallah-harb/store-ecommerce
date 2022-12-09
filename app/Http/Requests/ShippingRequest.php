<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'value'     => 'required',
            'plain_value'  => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [

            'value.required'    => 'يجب أدخال طريقه التوصيل',
            'plain_value.numeric'       =>'قيمه التوصيل بالارقام فقط',
        ];
    }
}
