<?php

namespace App\Http\Resources;

use App\Models\SuitParty;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseActivitySuitPartyResource extends JsonResource
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
            'case_activity_id' => $this->case_activity_id,
            'suitParty' => new SuitPartyResource(SuitParty::find($this->suit_party_id)),            
        ];
    }
}
