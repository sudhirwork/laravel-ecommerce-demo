<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrder extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|numeric|digits:10',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required|numeric',
            'state' => 'required|numeric',
            'country' => 'required|numeric',
            'zipcode' => 'required|numeric|digits:6'
        ];
    }
}
