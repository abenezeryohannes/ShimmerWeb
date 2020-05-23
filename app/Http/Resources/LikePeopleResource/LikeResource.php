<?php

namespace App\Http\Resources\LikePeopleResource;

use App\Http\Resources\FindPeopleResource\ProfileFPResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //id	user_id	picture_id	answare_id	notified	comment	type	created_at	updated_at
        return [
            
            'like' => new LikersResource($this),
            'profile' => new ProfileFPResource($this->profile)

             ];
    }
}
