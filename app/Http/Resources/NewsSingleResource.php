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
            "contents"=> $this->content,
            "picture"=> $this->image_desc,
            "date"=> date('d.m.Y', strtotime( $this->created_at)),
        ];
    }
} 
