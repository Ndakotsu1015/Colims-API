<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateStoreRequest extends FormRequest
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
            'state_code' => ['required', 'string'],
            'region_id' => ['integer', 'gt:0'],
            'state_code2' => ['string'],
            'is_active' => ['required'],
        ];
    }
}
