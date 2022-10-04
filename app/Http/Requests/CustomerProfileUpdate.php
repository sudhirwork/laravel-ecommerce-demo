<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerProfileUpdate extends FormRequest
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
            'profile_image' => 'image|mimes:png,jpeg,jpg',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:customers,email,'.Auth::guard('customer')->user()->id,
            'mobile' => 'required|numeric|digits:10|unique:customers,mobile,'.Auth::guard('customer')->user()->id,
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required|numeric',
            'state' => 'required|numeric',
            'country' => 'required|numeric',
            'zipcode' => 'required|numeric|digits:6'
        ];
    }
}
