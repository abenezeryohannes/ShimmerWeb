<?php

namespace App\Http\Resources\MatchedPeopleResource;

use Carbon;
use App\Http\Resources\FindPeopleResource\Q_and_AFPResource;
use App\Http\Resources\FindPeopleResource\PictureFPResource;

use Illuminate\Http\Resources\Json\JsonResource;


class ChatResource extends JsonResource
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
        
        return [
            'id'=> $this->id,
            'sender' => $this->sender_id,
            'receiver' => $this->reciever_id,
            'text' => $this->message,
            'seen' => $this->seen,
            'time' => $time->toDateTimeString()
            ];
    }


}
