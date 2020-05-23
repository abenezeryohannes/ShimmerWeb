<?php

namespace App\Http\Resources\ChatResource;

use Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class Chat extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {        
        $createdAt = Carbon::parse($this->created_at);
        return [
            'id'=>$this->id,
            'sender' => $this->sender_id,
            'receiver' => $this->reciever_id,
            'match_id' => $this->match_id,
            'text' => $this->message,
            'seen' => $this->seen,
            'time' => $createdAt
            ];
    }


}
