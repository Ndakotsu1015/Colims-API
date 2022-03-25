<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractDocumentSubmissionEntryUpdateRequest extends FormRequest
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
            'filename' => ['required', 'string'],
            'is_approved' => ['required'],
            'entry_id' => ['required', 'integer', 'exists:entries,id'],
            'document_type_id' => ['required', 'integer', 'exists:contract_document_types,id'],
        ];
    }
}
