<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    private $user1, $user2, $message_id;

    //Womens they only cares about there feelings
    //They don't give a shit about there father and mother
    //Thats what i am saying bitch
    public function scopeChats($query, $user_id_1, $user_id_2)
    {

        $this->user1 = $user_id_1;
        $this->user2 = $user_id_2;
        return $query->join('messages', 'messages.match_id', '=', 'matches.id')
        ->where(function($query) {
            $query->Where('messages.sender_id',  $this->user1)
            ->Where('messages.reciever_id',  $this->user2);
        })->Orwhere(function($query){
            $query->Where('messages.reciever_id',  $this->user1)
            ->Where('messages.sender_id', $this->user2);
        })->orderBy('messages.created_at', 'desc');
    }


    public function messages(){
        return $this->belongsTo('App\Message', 'user_id_1', 'sender_id');
    }


    public function profile(){
        return $this->belongsTo('App\Profile', 'user_id_2', 'user_id');
    }


    public function profile1(){
        return $this->belongsTo('App\Profile', 'user_id_1', 'user_id');
    }



    public function profile2(){
        return $this->belongsTo('App\Profile', 'user_id_2', 'user_id');
    }


    public function scopeMatches($query, $user_id_1)
    {
        $this->user1 = $user_id_1;
        return $query
        ->where('user_id_1','=',  $user_id_1)
        ->Orwhere('user_id_2', '=',  $user_id_1)
        ->where('matches.valid', '=', true)
        ->orderBy('created_at', 'desc');
    }



    public function scopeGetMatch($query, $user_id_1, $user_id_2)
    {

        //change this
        $this->user1 = $user_id_1;
        $this->user2 = $user_id_2;
        return $query->where(function($query) {
            $query->Where('user_id_1','=',  $this->user1)
            ->Where('user_id_2', '=',  $this->user2);
        })->Orwhere(function($query){
            $query->Where('user_id_2', '=',  $this->user1)
            ->Where('user_id_1', '=', $this->user2);
        })->where('matches.valid', '=', true)
        ->orderBy('created_at', 'desc');
    }







    public function scopeGetUnseenCount($query, $user_id_1, $user_id_2){
        return $query->join('messages', function($join){
                $join->on('messages.match_id', '=', 'matches.id');
        })

            
        ->where('messages.reciever_id', '=', $user_id_1)
        ->where('messages.sender_id', '=', $user_id_2)
        ->where('messages.seen', false)
        ->distinct()->count();
    }




    public function scopeGetNewMessages($query, $user_id_1, $user_id_2, $message_id){
        return $query->join('messages', function($join){
                $join->on('messages.sender_id', '=', 'matches.user_id_2')
                ->on('messages.reciever_id', '=', 'matches.user_id_1')
                ->oron('messages.sender_id', '=', 'matches.user_id_1')
                ->on('messages.reciever_id', '=', 'matches.user_id_2');
        })
        ->where('messages.reciever_id', '=', $user_id_1)
        ->where('messages.sender_id', '=', $user_id_2)
        ->where('messages.id', $message_id)
        ->where('matches.valid', '=', true)
        ->orderBy('messages.created_at', 'desc');
    }



    public function scopeGetNewMessagesAfter($query, $user_id_1){
        // return

        // DB::table('matches')
        // ->join('messages', 'matches.id', '=', 'messages.match_id')
        // ->where('messages.reciever_id', '=', $user_id_1)
        // ->orwhere('messages.sender_id', '=', $user_id_1);
        // // ->get();



        return $query->join('messages', function($join){
                $join
                ->on('messages.match_id', '=', 'matches.id');
        })
        ->where('messages.reciever_id', '=', $user_id_1)
        ->orwhere('messages.sender_id', '=', $user_id_1)
        ->where('matches.user_id_1', '=', $user_id_1)
        ->orwhere('matches.user_id_2', '=', $user_id_1)
        ->where('matches.valid', '=', true)
        ->orderBy('messages.created_at', 'desc');


    }



}
