<?php

namespace App\Http\Controllers;

use App\User;
use App\Payment;
use App\PaymentType;
use App\Boost;
use App\Setting;
use App\Http\Resources\PaymentResource\UserOperations; 
use Carbon;
use App\Http\Resources\FindPeopleResource\BoostResource;
use App\Http\Resources\FindPeopleResource\BoostResourceWrapper;
use Illuminate\Http\Request;

class BoostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function boost(Request $request)
    {
        //get unexpired payment plans
        //count the total allowed boost number
        // if not count is equal or greater than paid one
        // boost

        $validatedUser = $request->validate([
            'user_id' => 'required',
        ]);

        $allowed_boost = BoostController::leftBoost($request['user_id']);

        // $payment = Payment::where('user_id', '=', $request['user_id'])->where('expiration_date', '>', Carbon::now())->orderBy('created_at', 'desc')->get();
        // if($payment == null || sizeOf($payment) == 0) return "You didn't pay anything upto now";
        // if(sizeOf($payment) == 0) return "Be a member to Unlock boost feature";
        // //check boost 
        // $count = 0;
        // foreach ($payment as $p) {
        //     $paymentType = PaymentType::where('id', '=', $p->payment_type_id)->first();
        //     if($paymentType->type == "boost"){
        //         $count+=$paymentType->number_of_days;
        //     }else if ($paymentType->type == "subscribtion"){
        //         $count+=$paymentType->boost_minutes;
        //     }
        // }
        // if($count == 0) return "no boost even though your a member";
        if($allowed_boost == 0){
            return response()->json(["status"=>"failure", "message"=>"You have no left boost."]);
        }
        else{
            //get all boosts after the olders active payments
            //$boost  = Boost::where('created_at', '>', $payment[0])->get();
                //booost is allowed create boost 
                $boostMinute = Setting::first()->boost_minutes;
                $boost = new Boost();
                $boost->user_id = $request['user_id'];
                $boost->start_time = Carbon::now();
                $boost->boost_time = $boostMinute;
                $boost->expiration_date = Carbon::now()->addMinutes($boostMinute);
                $boost->save();
                return response()->json([
                     "status" => "successfull",
                     "body"=> BoostResourceWrapper::make($boost)->boost($boost)//Response()->json(Match::GetUnseenCount(1, 2));//

                ]);;
        }
    }

    
    public static function leftBoost($user_id){
        $user = User::find($user_id);
                $now = Carbon::now()->toDateString();
                $user_created = Carbon::parse($user->created_at);
            
                $totalMonthsPassed = $user_created->diffInMonths($now);
                
                $free_boosts_per_month = Setting::first()->free_boosts_per_month;


        $total_free_boosts = ($totalMonthsPassed+1) * $free_boosts_per_month;
                //dd($total_free_boosts);

        $total_paid_boost = 0;

                $payment = $user->payment()->where('expiration_date', '>', Carbon::now())->orderBy('created_at', 'desc')->get();
                if($payment != null && sizeOf($payment) != 0)
                foreach ($payment as $p) {
                    $paymentType = PaymentType::where('id', '=', $p->payment_type_id)->first();
                    if($paymentType->type == "boost"){
                        $total_paid_boost+=$paymentType->number_of_days;
                    }else if ($paymentType->type == "subscribtion"){
                        $total_paid_boost+=$paymentType->boost_minutes;
                    }
                }    
                // dd($total_paid_boost);
        $total_used_boost = $user->boost()->count();
                //dd($total_used_boost);

        $left_boost = ($total_paid_boost + ($total_free_boosts)) - $total_used_boost;
        return ($left_boost > 0)? $left_boost : 0;
    }
}
