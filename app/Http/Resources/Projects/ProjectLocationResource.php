<?php

namespace App\Http\Resources\Projects;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectLocationResource extends JsonResource 
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
            "address"=>$this->address,
            "description"=>$this->description_location,
            "coordinates" => [
                "latitude" => $this->coordinates_latitude,
                "longitude" => $this->coordinates_longitude,
            ],
            "picture" =>  $this->image_location,
            
        ];
    }
}
