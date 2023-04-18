<?php

namespace App\Http\Resources\Projects;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            "slug" => $this->slug,
            "title" => [
                "first"=>$this->title_first,
                "second"=>$this->title_second
            ],
            "subtitle" => $this->subtitle,
            "description" => $this->description,
            "pictures" => [
                "main" => $this->image_main,
                "cover" => $this->image_cover,
                "informational" => $this->image_informational
            ],
            "pictures_description" => $this->pictures_description,
            "price" => $this->price,
            "units_title" => $this->units_title,
            "construction_date" => $this->construction_date,
            "is_announcement" => $this->is_announcement,
            "is_unique" => $this->is_unique,
        ];
    }
} 
