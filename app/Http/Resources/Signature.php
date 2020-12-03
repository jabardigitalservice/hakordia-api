<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Signature extends JsonResource
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
            'occupation_name' => $this->occupation_name,
            'content' => $this->content,
            'signature_url' => url('/').$this->signature_path,
        ];
    }
}
