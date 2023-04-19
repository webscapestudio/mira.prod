<?php

namespace App\Http\Resources;

use App\Models\AboutAchievements;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $about_achievements = AboutAchievements::where('about_achievementable_id',  $this->id)->filters()->get();

        if(isset($about_achievements[0])):
           $about_achievements = AboutAchievements::where('about_achievementable_id',  $this->id)->filters()->get();
        else:
           $about_achievements = null;
        endif;
        

        return [
            "title" => $this->title,
            "description" => $this->description,
            "text_size" => $this->text_size,
            "pictures" => [
                "desktop" => $this->image_desc,
                "mobile" => $this->image_mob,
            ],
            "achievements" => $about_achievements,
        ];
    }
}
