<?php

namespace App\Http\Resources\Projects;

use App\Models\ProjectUnit;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectPicturesResource extends JsonResource
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
        return $pictures;
    }
}
