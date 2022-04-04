<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseActivityStoreRequest extends FormRequest
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
            //'user_id' => ['required', 'integer', 'exists:users,id'],
            'case_status_id' => ['required', 'integer', 'exists:case_statuses,id'],
            'location' => ['nullable', 'string'],
            'court_pronouncement' => ['nullable', 'string'],
        ];
    }
}
