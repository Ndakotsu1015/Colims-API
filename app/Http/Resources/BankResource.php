<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
            'name' => $this->name,            
            'bank_code' => $this->bank_code,
            'contractorAffliates' => ContractorAffliateCollection::make($this->whenLoaded('contractorAffliates')),
        ];
    }
}
