<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AwardLetterInternalDocumentResource extends JsonResource
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
            'filename' => filter_var($this->filename, FILTER_VALIDATE_URL) ? $this->filename : asset('storage/' . $this->filename),
            'awardLetter' => new AwardLetterResource($this->whenLoaded('awardLetter')),
            'postedBy' => new UserResource($this->whenLoaded('postedBy')),
        ];
    }
}
