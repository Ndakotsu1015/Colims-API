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
            'contract_sum' => $this->contract_sum,
            'date_awarded' => $this->date_awarded,
            'last_bank_ref_date' => $this->last_bank_ref_date,
            'reference_no' => $this->reference_no,
            'contract_title' => $this->contract_title,
            // 'contract_detail' => $this->contract_detail,
            'duration' => new DurationResource($this->whenLoaded('duration')),
            // 'contract_category' => new ContractCategoryResource($this->whenLoaded('contractCategory')),
            'contractor' => new ContractorResource($this->whenLoaded('contractor')),
            'contractType' => new ContractTypeResource($this->whenLoaded('contractType')),
            // 'project_location' => $this->project_location,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'approvedBy' => new EmployeeResource($this->whenLoaded('approvedBy')),
            'bankReferences' => BankReferenceCollection::make($this->whenLoaded('bankReferences')),
            'commencement_date' => $this->commencement_date,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'internalDocuments' => AwardLetterInternalDocumentCollection::make($this->whenLoaded('internalDocuments')),
            'contractDocumentSubmission' => new ContractDocumentSubmissionResource($this->contractDocumentSubmission),
        ];
    }
}
