<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }


    
    public function scopeIsWithinMaxDistance($query, $latitude, $longitude, $radius = 3000) {

        // $haversine = "( 111.045 * acos( cos( radians(' . $latitude . ') ) 
        //             * cos( radians( locations.latitude ) ) 
        //             * cos( radians( locations.longitude ) 
        //             - radians(' . $longitude  . ') ) 
        //             + sin( radians(' . $latitude  . ') ) 
        //             * sin( radians( locations.latitude ) ) ) )";
    

        $haversine = "(6371 * acos(cos(radians(" . $latitude . ")) 
                    * cos(radians(`latitude`)) 
                    * cos(radians(`longitude`) 
                    - radians(" . $longitude . ")) 
                    + sin(radians(" . $latitude . ")) 
                    * sin(radians(`latitude`))))";




        return $query ->selectRaw("{$haversine} AS distance")
                     ->whereRaw("{$haversine} < ?", [$radius]);
    }
}
