<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManifestoResource extends JsonResource
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
            "title"=> $this->title,
            "description"=> $this->description,
            "pictures_titles"=> [
                "first"=> $this->image_desc_title,
                "second"=> $this->image_mob_title
            ],
            "pictures"=> [
                "first"=> $this->image_desc,
                "second"=> $this->image_mob
            ]
        ];
    }
}
