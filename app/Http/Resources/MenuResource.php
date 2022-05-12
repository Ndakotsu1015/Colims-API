<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'icon' => $this->icon,
            'parent' => new MenuResource($this->whenLoaded('parentMenu')),
            'module' => new ModuleResource($this->whenLoaded('module')),
        ];
    }
}
