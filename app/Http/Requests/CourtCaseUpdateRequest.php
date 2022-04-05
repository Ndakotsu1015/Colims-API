<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourtCaseUpdateRequest extends FormRequest
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
            'case_no' => ['required', 'string'],
            'handler_id' => ['required', 'integer', 'exists:users,id'],
            //'posted_by' => ['required'],
            //'case_request_id' => ['required', 'integer', 'exists:case_requests,id'],
            'solicitor_id' => ['required', 'integer', 'exists:solicitors,id'],
            //'case_status_id' => ['required', 'integer', 'exists:case_statuses,id'],
            'is_case_closed' => ['nullable', 'boolean'],
            //'court_pronouncement' => ['nullable', 'string'],
            'court_judgement' => ['nullable', 'string'],
            'court_stage' => ['nullable', 'integer|gt:0'],
            'has_moved' => ['nullable', 'boolean'],
            'judgement_document_file' => ['nullable', 'string']
        ];
    }
}
