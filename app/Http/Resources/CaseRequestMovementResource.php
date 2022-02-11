<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseRequestMovementResource extends JsonResource
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
            'caseRequest' => new CaseRequestResource($this->whenLoaded('caseRequest')),
            'user' => new UserResource($this->whenLoaded('user')),
            'forwardTo' => new UserResource($this->whenLoaded('forwardTo')),
            'notes' => $this->notes,
        ];
    }
}
