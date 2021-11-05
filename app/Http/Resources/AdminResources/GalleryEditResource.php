<?php

namespace App\Http\Resources\AdminResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GalleryEditResource extends JsonResource
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
            'fetched_at' => Carbon::now(),
            'category'   => new CategoryResource($this->whenLoaded('category')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
