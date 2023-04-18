<?php

namespace App\Http\Resources\Projects;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectUnitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pictures = [];
        foreach($this->attachment as $attach):
            array_push($pictures, $attach->url);
        endforeach;
        return     [
            "id" => $this->id,
            "address" => $this->address,
            "type" => $this->type,
            "series" => $this->series,
            "price" => $this->price,
            "area" => $this->area,
            "bedrooms_quantity" => $this->bedrooms_quantity,
            "bathrooms_quantity" => $this->bathrooms_quantity,
            "floor" => $this->floor,
            "view" => $this->view,
            "pictures" => $pictures,
        ];
    }
}
