<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\News;
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

        if(News::orderby('id', 'desc')->first() == $this->where( 'id',$this->id)->first()):
            $is_last = true;
        else:
            $is_last = false;
        endif;
        return [
            "slug"=>$this->slug,
            "title"=> $this->title,
            "contents"=> $this->content,
            "picture"=> $this->image_desc,
            "date"=> date('d.m.Y', strtotime( $this->created_at)),
            "is_last"=> $is_last
        ];
    }
}
