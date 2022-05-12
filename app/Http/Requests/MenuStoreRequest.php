<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuStoreRequest extends FormRequest
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
            'title' => ['nullable','string'],
            'link' => ['required', 'string'],
            'order' => ['nullable','string'],
            'is_active' => ['required'],
            'icon' => ['nullable','string'],
            'parent_id' => ['nullable','exists:menus,id'],
            'module_id' => ['required', 'integer', 'exists:modules,id'],
        ];
    }
}
