<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AwardLetterUpdateRequest extends FormRequest
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
            'unit_price' => ['required', 'numeric'],
            'contract_sum' => ['required', 'numeric'],
            'no_units' => ['required', 'integer', 'gt:0'],            
            'date_awarded' => ['required', 'date'],
            'last_bank_ref_date' => ['nullable', 'date'],
            'reference_no' => ['required', 'string'],            
            'contractor_id' => ['required', 'integer', 'exists:contractors,id'],
            'contract_type_id' => ['required', 'integer', 'exists:contract_types,id'],
            'contract_category_id' => ['required', 'integer', 'exists:contract_categories,id'],
            'duration_id' => ['required', 'integer', 'exists:durations,id'],
            'contract_title' => ['required', 'string'],
            'contract_detail' => ['required', 'string'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'approved_by' => ['nullable'],
        ];
    }
}
