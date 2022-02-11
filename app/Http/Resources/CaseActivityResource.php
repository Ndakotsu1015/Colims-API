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
            'status' => $this->status,
            'location' => $this->location,
            'suitParties' => SuitPartyCollection::make($this->whenLoaded('suitParties')),
            'caseOutcome' => new CaseOutcomeResource($this->whenLoaded('caseOutcome')),
            'solicitor' => new SolicitorResource($this->whenLoaded('solicitor')),
        ];
    }
}
