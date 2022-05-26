<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuAuthorizationResource extends JsonResource
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
            'menu' => new MenuResource($this->whenLoaded('menu')),
            'privilege' => new PrivilegeResource($this->whenLoaded('privilege')),
        ];
    }
}
