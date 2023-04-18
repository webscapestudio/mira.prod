<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "slug"=> $this->slug,
            "title"=> $this->title,
            "content"=> $this->content,
            "picture"=> $this->image_desc,
            "date"=> $this->created_at,
        ];
    }
} 
