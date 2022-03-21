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
            'case_no' => ['required', 'string'],
            'title' => ['required', 'string'],
            'dls_approved' => [''],
            'review_submitted' => ['required'],
            'hanler_id' => ['required', 'integer', 'exists:hanlers,id'],
            'solicitor_id' => ['required', 'integer', 'exists:solicitors,id'],
            'case_request_id' => ['required', 'integer', 'exists:case_requests,id'],
        ];
    }
}
