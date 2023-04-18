<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            "year"=>$this->year,
            "title"=>$this->title,
            "description"=>$this->description,
            "pictures"=>[
                "desktop"=>$this->image_desc,
                "mobile"=>$this->image_mob
            ]
        ];
    }
}
