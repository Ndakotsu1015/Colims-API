<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'profile_picture' => filter_var($this->profile_picture, FILTER_VALIDATE_URL) ? $this->profile_picture : (is_null($this->profile_picture) ? null : config('app.url').'/file/get/' .$this->profile_picture),
        ];
    }
}
