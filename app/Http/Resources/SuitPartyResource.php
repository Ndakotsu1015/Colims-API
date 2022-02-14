<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuitPartyResource extends JsonResource
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
            'fullname' => $this->fullname,
            'phone_no' => $this->phone_no,
            'residential_address' => $this->residential_address,
            'courtCase' => new CourtCaseResource($this->whenLoaded('courtCase')),
            'caseParticipant' => new CaseParticipantResource($this->whenLoaded('caseParticipant')),
            'type' => $this->type,
        ];
    }
}
