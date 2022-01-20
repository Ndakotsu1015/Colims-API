<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuitPartyUpdateRequest extends FormRequest
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
            'fullname' => ['required', 'string'],
            'phone_no' => ['required', 'string'],
            'residential_address' => ['required', 'string'],
            'court_case_id' => ['required', 'integer', 'exists:court_cases,id'],
            'type' => ['required', 'string'],
        ];
    }
}
