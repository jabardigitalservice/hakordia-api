<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Vinkla\Hashids\Facades\Hashids;

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
            'id' => Hashids::encode($this->id),
            'type' => $this->type,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'occupation_name' => $this->occupation_name,
            'workplace_name' => $this->workplace_name,
            'content' => $this->content,
            'signature_url' => $disk->url('gen/'.$this->signature_path),
            'created_at' => $this->created_at,
        ];
    }
}
