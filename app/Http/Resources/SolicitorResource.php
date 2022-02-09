<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SolicitorResource extends JsonResource
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
            'office_address' => $this->office_address,
            'contact_name' => $this->contact_name,
            'contact_phone' => $this->contact_phone,
            'location' => $this->location,
            'state_id' => $this->state_id,
        ];
    }
}
