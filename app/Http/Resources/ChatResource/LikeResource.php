<?php

namespace App\Http\Resources\ChatResource;

use Carbon;
use App\Http\Resources\Picture;
use App\Http\Resources\Q_and_A;
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
        $time = (Carbon::parse($this->created_at));//Carbon::now()->diffInMilliSeconds
        //id	user_id	picture_id	answare_id	notified	comment	type	created_at	updated_at
        return [
            //this is likers model
            'id'=>$this->id,
            'liker_user_id' => $this->liker_user_id,//new LikersResource($this),
            'liked_user_id' => $this->liked_user_id,//new ProfileFPResource($this->profile)
            'liked_picture' => new Picture($this->picture),//i hate you
            'liked_question_and_answer' => new Q_and_A($this->answare),//
            'comment' => $this->comment,
            'super_like' => $this->super_like,
            'time' => $time->toDateTimeString() // < Carbon::now()->subDay())? $createdAt->format('F d Y'): $createdAt->format('h:m a')
             ];
    }
}
