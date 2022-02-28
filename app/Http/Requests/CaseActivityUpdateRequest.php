<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseActivityUpdateRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'court_case_id' => ['required', 'integer', 'exists:court_cases,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'status' => ['required', 'string'],
            'location' => ['required', 'string'],            
            'solicitor_id' => ['required', 'integer', 'exists:solicitors,id'],
        ];
    }
}
