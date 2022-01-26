<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractorStoreRequest extends FormRequest
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
            'contractor_name' => 'required|string',
            'address' => 'required|string',
            'location' => 'required|string',
            'email' => 'required|email',
            'phone_no' => 'required|string',
            'contact_name' => 'required|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'required|string',
        ];
    }
}
