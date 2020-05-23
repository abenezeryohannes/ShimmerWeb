<?php

namespace App\Http\Resources\FindPeopleResource;
use Carbon;

use App\Http\Controllers\BoostController;
use App\Http\Controllers\LikeController;
use App\Like;
use App\Setting;
use App\Boost;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BoostResourceWrapper extends ResourceCollection
{
    private $boost;
    public function boost($value){
        $this->boost = $value;
        return $this;
    }

    /** bety hawi eden senait
     * hawi bety eden senait
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->boost);

        $setting = Setting::first();
        // $expiration_date = Carbon::parse($this->boost->expiration_date);
        // $start_time = Carbon::parse($this->boost->start_time);

        return [
            "super_likes_this_day"=> Like::where("liker_user_id",  $this->boost->user_id)->where("super_like", "=", 1)->where("created_at", ">", Carbon::now()->subDays(1))->count(),
            "allowed_boost"=> BoostController::leftBoost($this->boost->user_id),
            "likes_this_day"=>Like::where("liker_user_id",  $this->boost->user_id)->where("super_like", "=", 0)->where("created_at", ">", Carbon::now()->subDays(1))->count(),
            "free_likes_per_day"=>$setting->free_likes_per_day,
            "free_boosts_per_month"=>$setting->free_boosts_per_month,
            "free_super_likes_left"=>LikeController::freeSuperLikeLeft($this->boost->user_id),

            "boost"=> new BoostResource($this->boost)
            ];
    }
}
