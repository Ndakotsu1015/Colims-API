<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivilegeDetailResource extends JsonResource
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
            'privilege_class' => new PrivilegeClassResource($this->whenLoaded('privilege_class')),            
            'user' => new UserResource($this->whenLoaded('user')),
            'privilege' => new PrivilegeResource($this->whenLoaded('privilege'))
        ];
    }
}
