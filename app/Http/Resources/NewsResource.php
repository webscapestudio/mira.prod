<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->paginate(10)->lastPage() == $this->paginate(10)->currentPage()):
            $is_last = true;
        else:
            $is_last = false;
        endif;
        return [
            "title"=> $this->title,
            "contents"=> $this->contents,
            "picture"=> $this->image_desc,
            "is_last"=> $is_last 
        ];
    }
}
