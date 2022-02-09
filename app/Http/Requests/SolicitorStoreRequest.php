<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitorStoreRequest extends FormRequest
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
            'office_address' => ['required', 'string'],
            'contact_name' => ['required', 'string'],
            'contact_phone' => ['required', 'string'],
            'location' => ['required', 'string'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
        ];
    }
}
