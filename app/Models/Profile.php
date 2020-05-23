<?php

namespace App;
use App\Location;
use Carbon;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    public function answers()
    {
        return $this->hasMany('App\Answare', 'user_id', 'user_id');
    }

    public function scopeGetPictures($query){


    }
    //picture
    public function pictures(){
        return $this->hasMany('App\Picture', 'user_id', 'user_id');
    }
    //preference
    public function preference(){
        return $this->hasOne('App\Preference', 'user_id', 'user_id');
    }
    //location
    public function location(){
        return $this->hasOne('App\Location', 'user_id', 'user_id');
    }
    //user
    public function user(){
        return $this->belongsTo('App\User');
    }
    //relationshipType
    public function relationshipTypes(){
        return $this->hasOne('App\relationship_types', 'user_id', 'user_id');
    }

    public function paymentInfo(){
        return $this->hasOne('App\Payment', 'user_id', 'user_id');
    }


    public function elloScore(){
        return $this->hasOne('App\ElloScore', 'user_id', 'user_id');
    }
    public function phonenumbers(){
        return $this->hasMany('App\Phonenumber', 'user_id', 'user_id');
    }


    public function lastTimeLoggedIn(){
        return $this->hasOne('App\LastTimeLoggedin', 'user_id', 'user_id');
    }

    public function boost(){
        return $this->hasMany('App\Boost', 'user_id', 'user_id');
    }

    public function scopePeoplesInDistance($query, $my_location, $max_distance)
    {
        if($my_location == null) return;
        $latitude = $my_location->latitude;
        $longitude = $my_location->longitude;

        return $query->with('location')->whereHas('location', function($q) use ($latitude, $longitude, $max_distance){

                if($latitude != null && $longitude != null){
                    $q->isWithinMaxDistance($latitude, $longitude, $max_distance);
                }

            })
            ->select('profiles.*');
    }


    public function scopeCalculateDesirability($query, $my_ello_score){

        $ello = 1000;
        $last = 30;

        return $query
                ->join('ello_scores', 'ello_scores.user_id','=',  'profiles.user_id')
                ->join('last_time_loggedins', 'last_time_loggedins.user_id','=',  'profiles.user_id')
                     ->orderByRaw('( ABS( (?) - (
                         (ello_scores.final_score * ?) + ( DATEDIFF(last_time_loggedins.time, CURDATE()) * ?)
                     ) ))', [($my_ello_score * $ello), $ello, $last])
                     ->select('profiles.*');

    }


    public function scopePeoplesNotMatchedWithYou($query, $user_id){

         $query->leftJoin('matches', function($join) use ($user_id){

            $join->On('matches.user_id_2','=',  'profiles.user_id')
                ->where('matches.user_id_1', '=',  $user_id)
                ->orOn('matches.user_id_2','=',  'profiles.user_id')
                ->where('matches.user_id_2','=',  $user_id);
            })
            ->whereRaw('matches.user_id_1 IS NULL AND matches.user_id_2 IS NULL')
            ->select('profiles.*');
    }




    public function scopeBoostedProfiles($query){
     $boosted_profiles =clone  $query;
     $boosted_profiles->join('boosts', 'profiles.user_id','=',  'boosts.user_id')
        ->where('boosts.expiration_date', '>', Carbon::now())->distinct('profiles.user_id');
        // print($boosted_profiles->get());
        return $boosted_profiles->select('profiles.*');
    }



    public function scopeUnBoostedProfiles($query){
        $unboosted_profiles =clone  $query;
        $unboosted_profiles->leftJoin('boosts', function($join){
            $join->On('profiles.user_id','=',  'boosts.user_id');
            })->whereRaw('boosts.expiration_date IS NULL');
            // print($unboosted_profiles->get());
            return $unboosted_profiles->select('profiles.*');
    }


    public function scopePeoplesYouDidntNoped($query, $user_id){

        $query->leftJoin('nopes', function($join) use ($user_id){

            $join->On('nopes.noped_id','=',  'profiles.user_id')
                ->where('nopes.noper_id', '=',  $user_id);
            })
            ->whereRaw('nopes.noper_id IS NULL AND nopes.noped_id IS NULL')
            ->select('profiles.*');
    }


}
