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
            'is_case_closed' => $this->is_case_closed,           
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,            
            'caseStatus' => new CaseStatusResource($this->whenLoaded('caseStatus')),
            'handler' => new UserResource($this->whenLoaded('handler')),
            'solicitor' => new SolicitorResource($this->whenLoaded('solicitor')),
            'postedBy' => new UserResource($this->whenLoaded('postedBy')),
            'caseActivities' => CaseActivityCollection::make($this->whenLoaded('caseActivities')),            
            'suitParties' => SuitPartyCollection::make($this->whenLoaded('suitParties')),
            'legalDocuments' => LegalDocumentCollection::make($this->whenLoaded('legalDocuments')),
            'caseRequest' => new CaseRequestResource($this->whenLoaded('caseRequest')),
        ];
    }
}
