<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            //
            'name' => 'required|min:2|unique:permissions,name',
//            'phone'  => 'min:8',
//            'email' => 'email',
//            'location' => 'min:3',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'province'  => 'required',
//            'fax'  => 'min:8',
        ];
    }
}
