<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractDocumentSubmissionEntryResource extends JsonResource
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
            'filename' => $this->filename,
            'is_approved' => $this->is_approved,
            'has_uploaded' => $this->filename ? true : false,
            'entry_id' => $this->entry_id,
            'contractDocumentType' => new ContractDocumentTypeResource($this->whenLoaded('contractDocumentType')),
        ];
    }
}
