<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LegalDocumentResource extends JsonResource
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
            'filename' => $this->filename,
            'user_id' => $this->user_id,
            'courtCase' => new CourtCaseResource($this->whenLoaded('courtCase')),
        ];
    }
}
