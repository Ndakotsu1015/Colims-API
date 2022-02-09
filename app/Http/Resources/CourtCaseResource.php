<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourtCaseResource extends JsonResource
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
            'case_no' => $this->case_no,
            'status' => $this->status,
            'caseOutcome' => new CaseOutcomeResource($this->whenLoaded('caseOutcome')),
            'caseStatus' => new CaseStatusResource($this->whenLoaded('caseStatus')),
            'handler' => new UserResource($this->whenLoaded('handler')),
            'solicitor' => new UserResource($this->whenLoaded('solicitor')),
            'postedBy' => new UserResource($this->whenLoaded('postedBy')),
            'caseActivities' => CaseActivityCollection::make($this->whenLoaded('caseActivities')),
        ];
    }
}
