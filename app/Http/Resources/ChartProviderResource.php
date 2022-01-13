<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChartProviderResource extends JsonResource
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
            'chart_provider' => $this->chart_provider,
            'chartCategories' => ChartCategoryCollection::make($this->whenLoaded('chartCategories')),
        ];
    }
}
