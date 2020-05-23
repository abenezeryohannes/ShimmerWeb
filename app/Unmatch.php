<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unmatch extends Model
{
    //
    protected $table = 'unmatch';

    protected $user;
    
    public function scopeGetUnmatchesOf($query, $user)
    {
       
        //change this
        $this->user = $user;
        return $query->where(function($query) {
            $query->Where('user_id_1','=',  $this->user);
        })->Orwhere(function($query){
            $query->Where('user_id_2', '=',  $this->user);
        })->orderBy('created_at', 'desc');
    }




}
