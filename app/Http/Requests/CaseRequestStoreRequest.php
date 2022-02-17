<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequestStoreRequest extends FormRequest
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
            'content' => ['required', 'string'],
            // 'request_origin' => ['required', 'string'],
            'memo_file' => ['nullable', 'string'],
            // 'initiator_id' => ['required', 'integer', 'exists:users,id'],
            // 'case_reviewer_id' => ['nullable', 'integer', 'exists:users,id'], 
            // 'status' => ['required', 'string'],
            // 'initiator_id' => ['required', 'integer', 'exists:initiators,id'],
            // 'status' => ['required', 'string'],
        ];
    }
}
