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
            'memo_file' => filter_var($this->memo_file, FILTER_VALIDATE_URL) ? $this->memo_file : (is_null($this->memo_file) ? null : config('app.url') . '/file/get/' . $this->memo_file),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'initiator' => new UserResource($this->whenLoaded('initiator')),
            'caseReviewer' => new UserResource($this->whenLoaded('caseReviewer')),
            'status' => $this->status,
            'recommendation_note' => $this->recommendation_note,
            'should_go_to_trial' => $this->should_go_to_trial,
            'is_case_closed' => $this->is_case_closed,
            'recommendation_note_file' => filter_var($this->recommendation_note_file, FILTER_VALIDATE_URL) ? $this->recommendation_note_file : (is_null($this->recommendation_note_file) ? null : config('app.url') . '/file/get/' . $this->recommendation_note_file),
            'caseDraft' => new CaseDraftResource($this->whenLoaded('caseDraft')),
        ];
    }
}
