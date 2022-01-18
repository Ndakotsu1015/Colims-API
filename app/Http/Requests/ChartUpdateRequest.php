<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChartUpdateRequest extends FormRequest
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
            'chart_title' => ['required', 'string'],
            'sql_query' => ['required', 'string'],
            'is_active' => ['required'],
            'module_id' => ['required', 'integer', 'exists:modules,id'],
            'filter_column' => ['required', 'string'],
            'chart_type_id' => ['required', 'integer', 'exists:chart_types,id'],
            'chart_category_id' => ['required', 'integer', 'exists:chart_categories,id'],
        ];
    }
}
