<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequestUpdateRequest extends FormRequest
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
            'title' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],            
            'memo_file' => ['nullable', 'string'],
            'recommendation_note' => ['nullable', 'string'],
            'should_go_to_trial' => ['nullable', 'boolean'],
            'status' => ['nullable', 'string'],
            'case_reviewer_id' => ['nullable', 'int'],
        ];
    }
}
