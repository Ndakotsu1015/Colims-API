<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseDraftSuitPartyUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'phone_no' => ['required', 'string'],
            'address' => ['required', 'string'],
            'email' => ['required', 'email'],
            'type' => ['required', 'string'],
            'case_draft_id' => ['required', 'integer', 'exists:case_drafts,id'],
        ];
    }
}
