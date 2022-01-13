<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'state_code' => $this->state_code,
            'region_id' => $this->region_id,
            'state_code2' => $this->state_code2,
            'is_active' => $this->is_active,
            'awardLetters' => AwardLetterCollection::make($this->whenLoaded('awardLetters')),
        ];
    }
}
