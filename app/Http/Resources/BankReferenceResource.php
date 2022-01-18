<?php

namespace App\Http\Resources;

use App\Models\AwardLetter;
use Illuminate\Http\Resources\Json\JsonResource;

class BankReferenceResource extends JsonResource
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
            'reference_date' => $this->reference_date,
            'volume_no' => $this->volume_no,
            'reference_no' => $this->reference_no,            
            'in_name_of' => $this->in_name_of,
            'affliate_id' => $this->affliate_id,
            'awardLetter' => new AwardLetter($this->whenLoaded('awardLetter')),
        ];
    }
}
