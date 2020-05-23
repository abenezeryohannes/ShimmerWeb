<?php

namespace App\Http\Resources\PaymentResource;

use Carbon;
use App\Http\Controllers\BoostController;
use App\Http\Controllers\LikeController;
use App\Like;
use App\Setting;
use App\Boost;
use App\Payment as PaymentModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPayment extends ResourceCollection
{
    private $user;
    public function user($value){
        $this->user = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $setting = Setting::first();
        return[
            "super_likes_this_day"=> Like::where("liker_user_id",  $this->user)->where("super_like", "=", 1)->where("created_at", ">", Carbon::now()->subDays(1))->count(),
            "allowed_boost"=> BoostController::leftBoost($this->user),
            "likes_this_day"=>Like::where("liker_user_id",  $this->user)->where("super_like", "=", 0)->where("created_at", ">", Carbon::now()->subDays(1))->count(),
            "free_likes_per_day"=>$setting->free_likes_per_day,
            "free_boosts_per_month"=>$setting->free_boosts_per_month,
            "free_super_likes_left"=>LikeController::freeSuperLikeLeft($this->user),

            "data" => $this->collection->map(

                function(PaymentModel $pm) use($request){
                    $resource = new  Payment($pm);
                    return $resource->toArray($request);
                }

             )->all()];

    }


}
