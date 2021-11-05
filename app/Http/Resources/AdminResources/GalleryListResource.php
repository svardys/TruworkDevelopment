<?php

namespace App\Http\Resources\AdminResources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryListResource extends JsonResource
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
            'title' => $this->title,
            'created_at' => $this->created_at->timezone('Europe/Prague')->format('d. m. Y'),
            'user'   => new UserResource($this->whenLoaded('user')),
            'category'   => new CategoryResource($this->whenLoaded('category')),
            'thumbnail'  => ImageResource::collection($this->whenLoaded('images')),
            'slug'       => $this->slug
        ];
    }
}
