<?php

namespace App\Http\Resources;

use App\Models\Social;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $socials=Social::all();
        return [
            "address"=>$this->address,
            "email"=>$this->email,
            "phone"=>$this->phone,
            "social"=>$socials
        ];
    }
}
