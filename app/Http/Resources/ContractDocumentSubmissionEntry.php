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
<<<<<<< HEAD:app/Http/Resources/ContractDocumentSubmissionEntryResource.php
            // 'entry_id' => $this->entry_id, //new ContractDocumentSubmissionResource($this->entry),
=======
            'entry' => new ContractDocumentSubmissionResource($this->entry),
>>>>>>> 9f151b27eebbae4e09b0af993195922eb6737d86:app/Http/Resources/ContractDocumentSubmissionEntry.php
            'contractDocumentType' => new ContractDocumentTypeResource($this->whenLoaded('contractDocumentType')),
        ];
    }
}
