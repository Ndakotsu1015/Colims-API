<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChartCategoryResource extends JsonResource
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
            'chart_category' => $this->chart_category,
            'chartProvider' => new ChartProviderResource($this->whenLoaded('chartProvider')),
            'dashboardSettings' => DashboardSettingCollection::make($this->whenLoaded('dashboardSettings')),
        ];
    }
}
