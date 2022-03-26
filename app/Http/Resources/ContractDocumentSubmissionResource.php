<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractDocumentSubmissionResource extends JsonResource
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
            'is_submitted' => $this->is_submitted,
            'is_approved' => $this->is_approved,
            'due_date' => $this->due_date,
            'awardLetter' => new AwardLetterResource($this->whenLoaded('awardLetter')),
            'contractDocumentSubmissionEntries' => ContractDocumentSubmissionEntryCollection::make($this->contractDocumentSubmissionEntries),
            'url_token' => $this->url_token,
            'access_code' => $this->access_code,
        ];
    }
}
