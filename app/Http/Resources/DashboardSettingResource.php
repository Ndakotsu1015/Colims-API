<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chart_title' => $this->chart_title,
            'is_active' => $this->is_active,
            'orderby' => $this->orderby,
            'is_group' => $this->is_group,
            'sub_module_id' => $this->sub_module_id,
            'chart_id' => $this->chart_id,
            'module_id' => $this->module_id,
            'chart_type_id' => $this->chart_type_id,
            'chart_category_id' => $this->chart_category_id,
        ];
    }
}
