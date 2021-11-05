<?php

namespace App\Http\Resources\PublicResources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryIndexResource extends JsonResource
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
            'slug' => $this->slug,
            'category'   => new CategoryResource($this->whenLoaded('category')),
            'thumbnail' => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
