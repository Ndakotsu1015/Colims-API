<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuitPartyUpdateRequest extends FormRequest
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
            'phone_no' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
        ];
    }
}
