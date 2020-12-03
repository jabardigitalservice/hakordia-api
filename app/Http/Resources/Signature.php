<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $disk = Storage::cloud();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'occupation_name' => $this->occupation_name,
            'content' => $this->content,
            'signature_url' => $disk->url('gen/'.$this->signature_path),
        ];
    }
}
