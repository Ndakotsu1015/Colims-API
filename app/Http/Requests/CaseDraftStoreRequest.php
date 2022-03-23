<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseDraftStoreRequest extends FormRequest
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
            'title' => ['nuallable', 'string'],
            'dls_approved' => [''],
            'review_submitted' => ['nullable', 'string'],
            'review_comment' => ['nullable', 'string'],
            'handler_id' => ['nuallable', 'integer', 'exists:users,id'],
            'solicitor_id' => ['nuallable', 'integer', 'exists:solicitors,id'],
            'case_request_id' => ['required', 'integer', 'exists:case_requests,id'],
        ];
    }
}
