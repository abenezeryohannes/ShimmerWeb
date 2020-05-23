<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //answare picture
    public function answare(){
        return $this->belongsTo('App\Answare');
    }
    public function picture(){
        return $this->belongsTo('App\Picture');
    }

    public function Q_and_A(){
        return $this->belongsTo('App\Answare');
    }
    public function profile(){
        return $this->belongsTo('App\Profile', 'liker_user_id', 'user_id');
    }

    public function userLiker(){
        return $this->belongsTo('App\User', 'liker_user_id', 'id');
    }
    public function userLiked(){
        return $this->belongsTo('App\User', 'liked_user_id', 'id');
    }

    private $user_id_1, $user_id_2;
    public function scopeLikeForChat($query, $user_id_1, $user_id_2){
        $this->user_id_1 = $user_id_1;
        $this->user_id_2 = $user_id_2;
        
        return $query->where(function($query) {
            $query->Where('liker_user_id', $this->user_id_1 )
            ->Where('liked_user_id',  $this->user_id_2);
        })->Orwhere(function($query){
            $query->Where('liker_user_id',  $this->user_id_2)
            ->Where('liked_user_id', $this->user_id_1);
        })->get();

        return $result;
    }


    
    public function scopeGetLikers($query, $user_id){

        $query->Where('liked_user_id', '=', $user_id)->
                    leftJoin('nopes', function($join) use ($user_id){
                    $join->On('nopes.noped_id','=',  'likes.liker_user_id')
                        ->where('nopes.noper_id', '=',  $user_id);
                    })
                    ->whereRaw('nopes.noper_id IS NULL AND nopes.noped_id IS NULL')
                    
                    ->leftJoin('matches', function($join) use ($user_id){

                    $join->On('matches.user_id_2','=',  'likes.liker_user_id')
                            ->where('matches.user_id_1', '=', $user_id)
                            ->orOn('matches.user_id_1','=',  'likes.liker_user_id')
                            ->where('matches.user_id_2','=',  $user_id);
                        })
                    ->whereRaw('matches.user_id_1 IS NULL AND matches.user_id_2 IS NULL')
                    
                    ->select('likes.*');

    }



























}
