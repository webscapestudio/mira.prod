<?php

namespace App\Http\Resources\Projects;

use App\Models\ProjectUnit;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $units = ProjectUnitsResource::collection(ProjectUnit::orderBy('sortdd', 'ASC')->where('project_unitable_id',  $this->project_unitable_id)
        ->where('id','!=' , $this->id)->get());
        $pictures = [];
        foreach($this->attachment as $attach):
            array_push($pictures, $attach->url);
        endforeach;
        return [
            "information"=>[
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
                "pictures" =>$pictures,
            ],
            "related_units"=>$units
        ];
    }
}
