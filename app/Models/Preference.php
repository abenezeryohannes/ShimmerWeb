<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function location(){
        return $this->hasOne('App\Location', 'user_id', 'user_id');
    }

    public function elloScore(){
        return $this->hasOne('App\ElloScore', 'user_id', 'user_id');
    }

}
