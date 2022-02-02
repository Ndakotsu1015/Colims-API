<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankReferenceStoreRequest extends FormRequest
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
            // 'created_by' => ['required', 'integer', 'exists:users,id'],
            'in_name_of' => ['required', 'string'],
            'affiliate_id' => ['required', 'integer', 'exists:contractor_affliates,id'],
            'award_letter_id' => ['required', 'integer', 'exists:award_letters,id'],
        ];
    }
}
