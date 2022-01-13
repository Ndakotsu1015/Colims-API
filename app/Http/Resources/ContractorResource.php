<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractorResource extends JsonResource
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
            'contractor_name' => $this->contractor_name,
            'address' => $this->address,
            'location' => $this->location,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'awardLetters' => AwardLetterCollection::make($this->whenLoaded('awardLetters')),
        ];
    }
}
