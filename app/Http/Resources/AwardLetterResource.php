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
            'contract_sum' => $this->contract_sum,
            'no_units' => $this->no_units,            
            'date_awarded' => $this->date_awarded,
            'reference_no' => $this->reference_no,            
            'contract_title' => $this->contract_title,
            'contract_detail' => $this->contract_detail,
            // 'duration' => new DurationResource($this->whenLoaded('duration')),
            'duration' => new DurationResource($this->duration),
            'contractCategory' => new ContractCategoryResource($this->contractCategory),
            // 'contract_category' => new ContractCategoryResource($this->whenLoaded('contract_category')),
            'contractor' => new ContractorResource($this->contractor),
            // 'contractor' => new ContractorResource($this->whenLoaded('contractor')),
            // 'contractType' => new ContractTypeResource($this->whenLoaded('contractType')),
            'contractType' => new ContractTypeResource($this->contractType),
            'state' => new StateResource($this->state),
            'project' => new ProjectResource($this->project),
            'approvedBy' => new EmployeeResource($this->approvedBy),
            'bankReferences' => BankReferenceCollection::make($this->whenLoaded('bankReferences')),
        ];
    }
}
