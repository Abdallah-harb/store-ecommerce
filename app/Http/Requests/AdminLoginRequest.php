<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'email'     => 'required|email',
            'password'  => 'required'
        ];
    }

    public function messages()
    {
        return [

                'email.required'    => 'يجب أدخال البريد الألكترونى',
                'email.email'       =>'البريد الألكترونى لابد ان يكون موثق',
                'password.required' => ' يجب أدخال كلمه السر'
        ];
    }
}
