<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankReferenceUpdateRequest extends FormRequest
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
            'reference_date' => ['required'],
            'volume_no' => ['required', 'integer', 'gt:0'],
            'reference_no' => ['required', 'integer', 'gt:0'],
            'created_by' => ['required', 'integer', 'gt:0'],
            'in_name_of' => ['required', 'string'],
            'affliate_id' => ['integer', 'gt:0'],
            'award_letter_id' => ['required', 'integer', 'exists:award_letters,id'],
        ];
    }
}
