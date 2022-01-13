<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractorAffliateResource extends JsonResource
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
            'account_no' => $this->account_no,
            'account_officer' => $this->account_officer,
            'account_officer_email' => $this->account_officer_email,
            'bank_address' => $this->bank_address,
            'sort_code' => $this->sort_code,
            'bank_id' => $this->bank_id,
        ];
    }
}
