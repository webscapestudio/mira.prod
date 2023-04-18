<?php

namespace App\Http\Resources\Projects;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectProgressPointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return     [
            "date" => $this->date,
            "title" => $this->title,
            "description" => $this->description,
            "pictures" => [
                "preview" => $this->image_preview,
                "main" => $this->image_main
            ],
            "video" => $this->video,
            "media_description" => $this->media_description,
        ];
    }
}
