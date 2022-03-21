<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AwardLetterContractDocumentSubmissionUpdateRequest extends FormRequest
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
            'is_submitted' => ['required'],
            'is_approved' => ['required'],
            'due_date' => ['required', 'date'],
            'award_letter_id' => ['required', 'integer', 'exists:award_letters,id'],
        ];
    }
}
