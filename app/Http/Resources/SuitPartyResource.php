<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuitPartyResource extends JsonResource
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
            'phone_no' => $this->phone_no,
            'address' => $this->address,
            'email' => $this->email,
            'courtCase' => new CourtCaseResource($this->whenLoaded('courtCase')),
            'type' => $this->type,
        ];
    }
}
