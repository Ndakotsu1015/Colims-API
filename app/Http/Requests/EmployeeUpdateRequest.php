<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'full_name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'designation' => ['required', 'string'],
            'signature_file' => ['required', 'string'],
            'is_approver' => ['required', 'boolean'],
        ];
    }
}
