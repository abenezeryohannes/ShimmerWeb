<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boost extends Model
{
    //

    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function profile()
    {
        return $this->belongsTo("App\Profile", "user_id","user_id");
    }

    

}
