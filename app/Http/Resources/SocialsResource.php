<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialsResource extends JsonResource
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
            "title"=> $this->title,
            "short_title"=> $this->short_title,
			"url"=> $this->url
        ];
    }
}
