<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseDraftUpdateRequest extends FormRequest
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
            'case_no' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'dls_approved' => [''],
            'review_submitted' => ['nullaable', 'string'],
            'review_comment' => ['nullable', 'string'],
            'handler_id' => ['nullable', 'integer', 'exists:hanlers,id'],
            'solicitor_id' => ['nullable', 'integer', 'exists:solicitors,id'],
            'case_request_id' => ['nullable', 'integer', 'exists:case_requests,id'],
        ];
    }
}
