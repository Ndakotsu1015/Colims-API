<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChartTypeUpdateRequest extends FormRequest
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
            'chart_type' => ['required', 'string'],
            'chart_category_id' => ['required', 'integer', 'exists:chart_categories,id'],
        ];
    }
}
