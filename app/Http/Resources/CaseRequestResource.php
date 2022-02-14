<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseRequestResource extends JsonResource
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
            'content' => $this->content,
            'request_origin' => $this->request_origin,
            'memo_file' => $this->memo_file,
            'initiator' => new UserResource($this->whenLoaded('initiator')),
            'status' => $this->status,
            'created_at' =>$this->created_at,
        ];
    }
}
