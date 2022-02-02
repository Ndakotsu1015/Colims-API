<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegalDocumentUpdateRequest extends FormRequest
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
            'filename' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'court_case_id' => ['required', 'integer', 'exists:court_cases,id'],
            'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
        ];
    }
}
