<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseActivityResource extends JsonResource
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
            'courtCase' => new CourtCaseResource($this->whenLoaded('courtCase')),
            'user' => new UserResource($this->whenLoaded('user')),
            'location' => $this->location,
            'caseActivitySuitParties' => CaseActivitySuitPartyCollection::make($this->whenLoaded('caseActivitySuitParties')),
            'solicitor' => new SolicitorResource($this->whenLoaded('solicitor')),
            'caseStatus' => new CaseStatusResource($this->whenLoaded('caseStatus')),
            'court_pronouncement' => $this->court_pronouncement ?? '(not set)',
        ];
    }
}
