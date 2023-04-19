<?php

namespace App\Http\Resources\Projects;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectUspResource extends JsonResource
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
            "title"=>$this->title_usp,
            "description"=>$this->description_usp,
            "logo" =>  $this->logo_usp,
            "pictures" => [
                "first" => $this->image_first_usp,
                "second" => $this->image_second_usp,
            ],
        ];
    }
}
