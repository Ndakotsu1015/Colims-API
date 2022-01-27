<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'full_name' => $this->full_name,
            'title' => $this->title,
            'designation' => $this->designation,
            // 'signature_file' => $this->signature_file,
            'signature_file' => filter_var($this->signature_file, FILTER_VALIDATE_URL) ? $this->signature_file : (is_null($this->signature_file) ? null : config('app.url').'/file/get/' .$this->signature_file),
        ];
    }
}
