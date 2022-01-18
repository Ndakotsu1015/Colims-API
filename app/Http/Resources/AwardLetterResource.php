<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AwardLetterResource extends JsonResource
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
            'unit_price' => $this->unit_price,
            'no_units' => $this->no_units,
            'no_rooms' => $this->no_rooms,
            'date_awarded' => $this->date_awarded,
            'reference_no' => $this->reference_no,
            'award_no' => $this->award_no,
            'volume_no' => $this->volume_no,
            'contractor' => new ContractorResource($this->whenLoaded('contractor')),
            'propertyType' => new PropertyTypeResource($this->whenLoaded('propertyType')),
            'state' => new StateResource($this->whenLoaded('state')),
            'project' => new ProjectResource($this->whenLoaded('project')),
            'posted_by' => new UserResource($this->whenLoaded('posted_by')),
            'bankReferences' => BankReferenceCollection::make($this->whenLoaded('bankReferences')),
        ];
    }
}
