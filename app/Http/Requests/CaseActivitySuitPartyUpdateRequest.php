<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseActivitySuitPartyUpdateRequest extends FormRequest
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
            'case_activity_id' => ['required', 'integer', 'exists:case_activities,id'],
            'suit_party_id' => ['required', 'integer', 'exists:suit_parties,id'],
        ];
    }
}
