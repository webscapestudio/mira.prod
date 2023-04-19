<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannersResource extends JsonResource
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
            "id"=>$this->id,
            "title" => [
                "first"=>$this->title_first,
                "second"=>$this->title_second,
            ],
            "pictures"=> [
                "desktop"=> $this->image_desc,
                "mobile"=> $this->image_mob
        ],
        "project"=>$this->project, 
        ];
    }
}
