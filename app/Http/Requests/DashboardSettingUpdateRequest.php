<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardSettingUpdateRequest extends FormRequest
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
            'is_active' => ['required'],
            'orderby' => ['required', 'integer', 'gt:0'],
            'is_group' => ['required'],
            'sub_module_id' => ['required', 'integer', 'gt:0'],
            'chart_id' => ['required', 'integer', 'exists:charts,id'],
            'module_id' => ['required', 'integer', 'exists:modules,id'],
            'chart_type_id' => ['required', 'integer', 'exists:chart_types,id'],
            'chart_category_id' => ['required', 'integer', 'exists:chart_categories,id'],
        ];
    }
}
