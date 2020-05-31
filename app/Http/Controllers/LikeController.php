<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikePeopleResource\LikeResource;
use App\Http\Resources\PaymentResource\UserOperations;
use App\Http\Resources\MatchedPeopleResource\MatchResource;
use App\Http\Resources\ChatResource\LikeResource as ChatLike;
use App\LastKnown;
use App\Like;
use App\Swipe;
use App\Match;
use Carbon;
use App\User;
use App\Setting;
use App\Payment;
use App\PaymentType;
use App\ElloScore;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likers(Request $request){
        $validatedUser = $request->validate([
            'user_id' => 'required',
        ]);

        // $likers = Like::Where('liked_user_id', '=', $request['user_id'])->orderBy('id', 'desc')->paginate(100);
        $likers = Like::GetLikers($request['user_id'])
                    ->orderBy('likes.id', 'desc')->paginate(100);

        $users = User::all();

        if(sizeof($likers)>0) {

            $lastKnown = LastKnown::where('user_id', '=', $request['user_id'])->first();
            $lastKnown->like_id = ($lastKnown->like_id != null && $lastKnown->like_id > $likers->last()->id) ? $lastKnown->like_id : $likers->last()->id;
            $lastKnown->save();
        }

        return LikeResource::collection($likers);
    }


    public function newLikers(Request $request){
        $validatedUser = $request->validate([
            'user_id' => 'required',
            'like_id' => 'required',
        ]);

        $likers = Like::GetLikers($request['user_id'])
                        ->where('likes.id', '>', $request['like_id'])
                        ->orderBy('likes.id', 'desc')->paginate(100);

        if(sizeof($likers)>0) {
            $lastKnown = LastKnown::where('user_id', '=', $request['user_id'])->first();
            $lastKnown->like_id = ($lastKnown->like_id != null && $lastKnown->like_id > $likers->first()->id) ? $lastKnown->like_id : $likers->first()->id;
            $lastKnown->save();
        }

//        dd($lastKnown);


        return LikeResource::collection($likers);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request)
    {
        $validatedUser = $request->validate([
        'liker_id' => 'required',
        'liked_id' => 'required',
    ]);
        if($request['answer_id'] == null && $request['picture_id'] == null) response()->json( [
                "status" => "un successfull"
            ]);


        $like = Like::where('liker_user_id', '=', $request['liker_id'])
                      ->where('liked_user_id', '=', $request['liked_id'])->first();

        if($like !=null) return response()->json([ "status" => "failure", "message"=>"You have liked these person before" ]);

        $like = new Like();
        $like->liker_user_id = $request['liker_id'];
        $like->liked_user_id = $request['liked_id'];

        if(($request['picture_id']!=null && ($request['picture_id']!=0 )))
            $like->picture_id = $request['picture_id'];

        if($request['answer_id']!=null && $request['answer_id']!=0)
            $like->answare_id = $request['answer_id'];


        if($request['type']!=null && $request['type'] == 'super_like'){

            if(LikeController::totalSuperLikeLeft($like->liker_user_id) > 0){
                $like->super_like = true;
            }else{
                return response()->json([ "status" => "failure", "message"=>"Dear "+User::find($like->liker_user_id)->first_name+", You are out of likes please add one subscribe to one of our membership plans to add your daily super likes usage!"]);
            }
         }
        else{
            $user = User::find($like->liker_user_id);

            $likes_count_day = $user->likes()->where('created_at', '>', Carbon::now()->subDays(1))->count();
            $activePayments = $user->FullActivePaymentSubscribtion()->get();
            if($activePayments == null || sizeOf($activePayments) == 0){
                $free_likes_per_day = Setting::first()->free_likes_per_day;
                $allowedLike = $free_likes_per_day - $likes_count_day;
                if($allowedLike<=0){
                    return response()->json([ "status" => "failure", "message"=>""+User::find($like->liker_user_id)->first_name+", You are out of Likes please subscribe to one of our membership plans." ]);
                }
            }else{
                $allowedLike = 0;
                foreach($activePayments as $v){

                     $allowedLike+=$v->PaymentTypes()->first()->likes_per_day;}

                $leftLikes = $allowedLike - $likes_count_day;
                if($leftLikes<=0){
                    return response()->json([ "status" => "failure", "message"=>""+User::find($like->liker_user_id)->first_name+", You have finished the total amount of likes add subscribtion plan to add to the number of likes." ]);
                }
            }
        }

        $like->notified = false;
        $like->comment = $request['comment'];
        $like->save();



         //update ello score

         $elloscore = ElloScore::where('user_id', '=', $request['liked_id'])->first();
         if($elloscore != null){
             $elloscore->like_count = $elloscore->like_count+1;
             if($elloscore->swipe_count>0) $elloscore->final_score = ($elloscore->like_count/$elloscore->swipe_count);
             else $elloscore->final_score = $elloscore->like_count;
         }else{
             $elloscore = new ElloScore();
             $elloscore->user_id = $request['liked_id'];
             $elloscore->swipe_count = 0;
             $elloscore->like_count = 1;
             $elloscore->final_score = 1;
             $elloscore->save();
         }




        $likeMeBefore = Like::where('liker_user_id', '=', $like->liked_user_id)->where('liked_user_id', '=', $like->liker_user_id)
                        ->first();

        if($likeMeBefore!=null){
            $match = new Match();
            $match->user_id_1 = $like->liker_user_id;
            $match->user_id_2 = $like->liked_user_id;
            $match->new = true;
            $match->seen = 0;
            $match->save();

            $spn = new SendPushNotificationController($like->userLiked()->first());
            $spn->sendNewMatchNotification($match);

        }else{

            $spn = new SendPushNotificationController($like->userLiked()->first());
            $spn->sendLikeNotification($like);

        }


        // dd($like->liker_user_id);
         if($likeMeBefore!=null){
            $matched = new MatchResource($match);
            return response()->json(['status'=>'match',
                                     "data" =>UserOperations::make($like)->user($like->liker_user_id),
                                     "new_match" =>  $matched->user($like->liker_user_id)
                                     ]);
         }
         else
          return response()->json([ "status" => "successfull", "data" => UserOperations::make($like)->user($like->liker_user_id ) ]);

    }


    public function getLikeForChat(Request $request){

        $validatedUser = $request->validate([
            'user_id_1' => 'required',
            'user_id_2' => 'required',
        ]);

        $like = Like::LikeForChat( $request['user_id_1'], $request['user_id_2'] );

        return  response()->json(["likes"=>ChatLike::collection($like)]);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function makeLikeSeen(Request $request)
    {
        $validatedUser = $request->validate([
            'like_id' => 'required',
            'user_id' => 'required',
        ]);
        $like = Like::find($request['like_id']);
        if($like == null)
        return response()->json(["status"=> "Invalid id"]);

        if($like->liked_user_id != $request['user_id'])
        return response()->json(["status"=> "You are not Allowed to make this operation"]);


        $like->seen = 1;
        $like->save();

        return response()->json(["status"=> "Successfull"]);
    }


    public static function freeSuperLikeLeft($user_id){
        $user = User::find($user_id);
        $total_paid_super_likes = 0;

                $payment = $user->FullPaymentSubscribtion()->where('expiration_date', '>', Carbon::now())->orderBy('created_at', 'desc')->first();
                //no active subscribtion payment
                if($payment == null){
                    $now = Carbon::now()->toDateString();

                    // dd("usb");
                    $last_payment = $user->FullPaymentSubscribtion()->orderBy('created_at', 'desc')->first();
                    if($last_payment == null){
                        $total_free_super_like = Setting::first()->free_super_likes_per_month;
                        $total_super_like_in_the_month = $user->likes()->where('super_like', '=', 1)->where('created_at', '>', Carbon::now()->subMonths(1))->count();
                        $total_allowed_in_this_month = ($total_free_super_like - $total_super_like_in_the_month);
                        return  $total_allowed_in_this_month>0 ? $total_allowed_in_this_month: 0;
                    }else $last_payment_expiry_date = Carbon::parse($last_payment->expiration_date);

                    if($last_payment_expiry_date->diffInMonths($now) > 0){

                        $total_free_super_like = Setting::first()->free_super_likes_per_month;
                        $total_super_like_in_the_month = $user->likes()->where('super_like', '=', 1)->where('created_at', '>', Carbon::now()->subMonths(1))->count();
                        $total_allowed_in_this_month = ($total_free_super_like - $total_super_like_in_the_month);
                        return  $total_allowed_in_this_month>0 ? $total_allowed_in_this_month: 0;

                    }else return 0;
                }else{
                    return 0;
                }
    }

    public static function totalSuperLikeLeft($user_id){
        $payment = Payment::where('user_id', '=', $user_id)->where('expiration_date', '>', Carbon::now())->get();
        if($payment == null || sizeOf($payment) == 0) {
            return LikeController::freeSuperLikeLeft($user_id);
        }else{
            $count_of_permited_dayly_super_like  = 0;
            foreach ($payment as $p) {
                $paymentType = PaymentType::where('id', '=', $p->payment_type_id)->first();
                if($paymentType->type == "subscribtion"){
                   $count_of_permited_dayly_super_like += $paymentType->super_likes_per_day;
                }
            }

            $number_of_super_like_daily = Like::where("liker_user_id", $request['liker_id'])->where("super_like", "=", "1")
                                                    ->where("created_at", ">", Carbon::now()->subDays(1))->count();

            $liked_left =  ($count_of_permited_dayly_super_like - $number_of_super_like_daily);
            return ($liked_left <=0 )? 0:$liked_left;
        }

    }


}
