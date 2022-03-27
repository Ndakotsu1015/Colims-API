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
            'filename' => filter_var($this->filename, FILTER_VALIDATE_URL) ? $this->filename : (is_null($this->filename) ? null : config('app.url').'/file/get/' .$this->filename),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'awardLetter' => new AwardLetterResource($this->whenLoaded('awardLetter')),
            'postedBy' => new UserResource($this->whenLoaded('postedBy')),
        ];
    }
}
