<?php

namespace App\Http\Resources\MatchedPeopleResource;


use App\Http\Resources\FindPeopleResource\ProfileFPResource;
use App\Http\Resources\MatchedPeopleResource\ChatResource;
use App\Message;
use Illuminate\Http\Resources\Json\JsonResource;


class MatchResource extends JsonResource
{

    private $user;

    public function user($value){
        $this->user = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'id'=>$this->id,
            'matcher_id' => $this->user_id_1,
            'seen' => $this->seen,
            'user_profile' => new ProfileFPResource( ($this->user == $this->user_id_1)? $this->profile2 : $this->profile1),
            'chat' => new ChatResource($this->Chats($this->user_id_1, $this->user_id_2)->first()),// new ChatResource($this->messages)
            'unseen_count' => 
            $this->GetUnseenCount(
                $this->user, 
                ($this->user == $this->user_id_1)? (string)$this->user_id_2 : (string)$this->user_id_1)
        ];

       
    }

    public static function collection($resource){
        return new MatchCollection($resource, get_called_class());
    }
    
}
