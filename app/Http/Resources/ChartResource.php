<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChartResource extends JsonResource
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
            'sql_query' => $this->sql_query,
            'is_active' => $this->is_active,
            'module_id' => $this->module_id,
            'filter_column' => $this->filter_column,
            'chart_type_id' => $this->chart_type_id,
            'chart_category_id' => $this->chart_category_id,
            'dashboardSettings' => DashboardSettingCollection::make($this->whenLoaded('dashboardSettings')),
        ];
    }
}
