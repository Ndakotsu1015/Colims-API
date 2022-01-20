<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarEventResource extends JsonResource
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
            'description' => $this->description,
            'location' => $this->location,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'postedBy' => new UserResource($this->whenLoaded('postedBy')),
            'courtCase' => new CourtCaseResource($this->whenLoaded('courtCase')),
        ];
    }
}
