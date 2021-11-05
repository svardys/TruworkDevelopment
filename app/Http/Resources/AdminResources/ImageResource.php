<?php

namespace App\Http\Resources\AdminResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ImageResource extends JsonResource
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
            'name' => $this->original_name,
            'path' => Storage::url($this->path),
            'thumbnail' => $this->thumbnail,
            'size' => $this->size
        ];
    }
}
