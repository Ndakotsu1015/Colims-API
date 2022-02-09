<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourtCaseStoreRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'case_no' => ['required', 'string', 'unique:court_cases,case_no'],
            'status' => ['required', 'string'],
            'handler_id' => ['required', 'integer', 'exists:users,id'],
            'posted_by' => ['required'],
            'case_outcome_id' => ['required', 'integer', 'exists:case_outcomes,id'],
            'solicitor_id' => ['required', 'integer', 'exists:solicitors,id'],
            'case_status_id' => ['required', 'integer', 'exists:case_statuses,id'],
        ];
    }
}
