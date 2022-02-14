<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequestMovementUpdateRequest extends FormRequest
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
            'case_request_id' => ['required', 'integer', 'exists:case_requests,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'forward_to' => ['required'],
            'notes' => ['required', 'string'],
        ];
    }
}
