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
            'contract_sum' => ['required', 'numeric'],
            'date_awarded' => ['required', 'date'],
            'last_bank_ref_date' => ['nullable', 'date'],
            'reference_no' => ['required', 'string'],
            'contractor_id' => ['required', 'integer', 'exists:contractors,id'],
            'contract_type_id' => ['required', 'integer', 'exists:contract_types,id'],
            // 'contract_category_id' => ['required', 'integer', 'exists:contract_categories,id'],
            'duration_id' => ['required', 'integer', 'exists:durations,id'],
            'contract_title' => ['required', 'string'],
            // 'contract_detail' => ['required', 'string'],
            // 'project_location' => ['nullable', 'string'],
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
            'approved_by' => ['nullable'],
            'commencement_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'award_letter_document_file' => ['nullable', 'string']
        ];
    }
}
