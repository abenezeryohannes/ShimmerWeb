<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    
    protected $fillable = [
        'sender_id', 'reciever_id', 'message'
    ];
    //
    private $user1;
    private $user2;
    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function scopeGetConversationOf($query, $user_id_1, $user_id_2){
        $this->user1 = $user_id_1;
        $this->user2 = $user_id_2;
        return $query->where(function($query) {
            $query->Where('messages.sender_id',  $this->user1)
            ->Where('messages.reciever_id',  $this->user2);
        })->Orwhere(function($query){
            $query->Where('messages.reciever_id',  $this->user1)
            ->Where('messages.sender_id', $this->user2);
        })->orderBy('id', 'desc');
    }

    public function scopeGetConversation($query, $user_id_1){
        $this->user1 = $user_id_1;
        return $query->where(function($query) {
            $query->Where('messages.sender_id',  $this->user1);
        })->Orwhere(function($query){
            $query->Where('messages.reciever_id',  $this->user1);
        })->orderBy('id', 'desc');
    }
}
