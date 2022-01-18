<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivilegeDetailStoreRequest extends FormRequest
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
            'privilege_class_id' => ['required', 'integer', 'exists:privilege_classes,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'privilege_id' => ['required', 'integer', 'exists:privileges,id'],
        ];
    }
}
