<?php

namespace App\Http\Resources\PublicResources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryShowResource extends JsonResource
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
            'title' => $this->title,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'category'   => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
