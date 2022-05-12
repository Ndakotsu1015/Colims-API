<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'name' => $this->name,
            'order_by' => $this->order_by,
            'active_id' => $this->active_id,
            'url' => $this->url,
            'icon' => $this->icon,
            'bg_class' => $this->bg_class,
            'menus' => MenuResource::collection($this->whenLoaded('menus')),
        ];
    }
}
