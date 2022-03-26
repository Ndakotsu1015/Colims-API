<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractDocumentSubmissionEntryStoreRequest extends FormRequest
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
            'name' => ['nullable', 'string'],
            'filename' => ['nullable', 'string'],
            'is_approved' => ['required'],
            'entry_id' => ['required', 'integer', 'exists:entries,id'],
            'contract_document_type_id' => ['required', 'integer', 'exists:contract_document_types,id'],
        ];
    }
}
