<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuUpdateRequest extends FormRequest
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
            'title' => ['string'],
            'link' => ['required', 'string'],
            'order' => ['string'],
            'is_active' => ['required'],
            'icon' => ['string'],
            'parent_id' => ['required', 'integer', 'exists:parents,id'],
            'module_id' => ['required', 'integer', 'exists:modules,id'],
        ];
    }
}
