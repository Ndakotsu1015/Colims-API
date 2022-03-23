<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CaseDraftResource extends JsonResource
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
            'case_no' => $this->case_no,
            'title' => $this->title,
            'dls_approved' => $this->dls_approved,
            'review_submitted' => $this->review_submitted,
            'handler_id' => $this->handler_id,
            'solicitor_id' => $this->solicitor_id,
            'case_request_id' => $this->case_request_id,
        ];
    }
}
