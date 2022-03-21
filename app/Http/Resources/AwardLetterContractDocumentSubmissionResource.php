<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AwardLetterContractDocumentSubmissionResource extends JsonResource
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
            'award_letter_id' => $this->award_letter_id,
            'awardLetterContractDocumentSubmissionEntries' => AwardLetterContractDocumentSubmissionEntryCollection::make($this->whenLoaded('awardLetterContractDocumentSubmissionEntries')),
        ];
    }
}
