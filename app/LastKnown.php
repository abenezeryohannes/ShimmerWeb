<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastKnown extends Model
{
    //
    public  function user(){
        return $this->belongsTo('users');
    }


    public function scopeGetLikes($user, $like_id){
        return Like::where('liked_user_id', '=', $user)
            ->where($like_id, '<', 'likes.id')
            ->get()->count();
    }

    public function scopeGetMessage($query){
        return $query->join('messages', function($join){
            $join->On('last_knowns.user_id', '=', 'messages.reciever_id');
        })
            ->where('last_knowns.message_id', '<', 'messages.id')
            ->get()->count();

    }


    public function scopeGetMatch($query){
        return $query->join('matches', function($join){
            $join->On('last_knowns.user_id', '=', 'matches.user_id_1')
            ->orOn('last_knowns.user_id', '=', 'matches.user_id_2');
            })
            ->where('last_knowns.match_id', '<', 'matches.id')
            ->get()->count();
    }


//    public function scopeGetPeoples($query){
//
//    }
}
