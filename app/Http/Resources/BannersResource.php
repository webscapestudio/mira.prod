<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Project;
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
        $project = Project::find($this->project);


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
        "project"=>$project->slug, 
        ];
    }
}
