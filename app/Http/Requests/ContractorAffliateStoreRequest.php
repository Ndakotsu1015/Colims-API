<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractorAffliateStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'account_no' => ['required', 'string'],
            'account_officer' => ['required', 'string'],
            'account_officer_email' => ['required', 'string'],
            'bank_address' => ['required', 'string'],
            'sort_code' => ['required', 'string'],
            'bank_id' => ['required', 'integer', 'exists:banks,id'],
        ];
    }
}
