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
            'module' => new ModuleResource($this->whenLoaded('module')),
            'filter_column' => $this->filter_column,
            'chartType' => new ChartTypeResource($this->whenLoaded('chartType')),
            'chartCategory' => new ChartCategoryResource($this->whenLoaded('chartCategory')),
            'dashboardSettings' => DashboardSettingCollection::make($this->whenLoaded('dashboardSettings')),
        ];
    }
}
