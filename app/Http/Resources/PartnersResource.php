<?php

namespace App\Http\Resources;

use App\Models\Partners;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnersResource extends JsonResource
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
        return [
            "title"=>$this->title,
		"logo"=>$this->logo,
		"description"=>$this->description,
		"pictures"=>$pictures,
        
        ];
    }
}
