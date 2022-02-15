<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuitPartyStoreRequest extends FormRequest
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
            'court_case_id' => ['required', 'integer', 'exists:court_cases,id'],            
            'case_participant_id' => ['required', 'integer', 'exists:case_participants,id'],
            'type' => ['required', 'string'],
        ];
    }
}
