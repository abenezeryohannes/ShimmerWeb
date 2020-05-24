<?php

namespace App\Http\Controllers;

use App\LastKnown;
use Illuminate\Http\Request;
use App\Http\Resources\LikePeopleResource\LikeResource;
use App\FCMToken;
use App\User;
use App\Like;
use App\Match;
use App\Payment;

class SendPushNotificationController extends Controller
{


    /**
    *
    * @var user
    * @var FCMToken
    */
    protected $user;
    /**
    * Constructor
    *
    * @param
    */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
    * Functionality to send notification.
    *
    */

    private function send($fields){
        define('AAAAS5D_ibI:APA91bH_ilPYA2qnNG7pbKSLlkm3c5r6DaoEJHxIAd-LYAZPdZrhpQJDU5xHIH8lReY-YkoR_VLgfuY-x9yXC1W6oH6BaXME-mnCeU_gar5c_Pu7LRYo1vbPu2C5ufjG4s01g7dT7Bgn',
        'AIzaSyBaEgYjDEwU8ifDjVCpaJWsvgzLzWvntGA' );
        $headers = array
        (
            'Authorization: key=' . 'AAAAS5D_ibI:APA91bH_ilPYA2qnNG7pbKSLlkm3c5r6DaoEJHxIAd-LYAZPdZrhpQJDU5xHIH8lReY-YkoR_VLgfuY-x9yXC1W6oH6BaXME-mnCeU_gar5c_Pu7LRYo1vbPu2C5ufjG4s01g7dT7Bgn',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        if ($result === FALSE)
            {
//              die('FCM Send Error: ' . curl_error($ch));
                return "FCM Send Error";
            }
        $result = json_decode($result,true);
        $responseData['android'] =[
                "result" =>$result
            ];
        curl_close( $ch );

        return $result;

    }





    public function sendNotification(Request $request)
    {
        $collapse_key = "information_key";
        $tokens = [];
        // $apns_ids = [];
        $responseData = [];
       // $data= $request->all();
        $users= $request['user_id'];
        // for Android
        if ($FCMTokenData = FCMToken::where('user_id',$users)->where('token','!=',null)->select('token')->get())
        {
            foreach ($FCMTokenData as $key => $value)
            {
                 $tokens[] = $value->token;
            }

        $msg = array
            (
                'tag' => $collapse_key,
                'body'  => 'This is body of Shimmer',
                'title' => 'Shimmer title',
                'subtitle' => 'This is a Shimmer subtitle',
            );
            if($tokens == null || sizeOf($tokens) == 0) return "No token found!!";
            $fields = array
            (
                'to'  => $tokens[0],
                'notification'  => $msg,
                'collapse_key' => $collapse_key
            );


        //dd($fields);
        $responseData['android'] =[
            "result" => $this->send($fields)
        ];
    }
    return $responseData;
}




    public function sendLikeNotification(Like  $like){



        $collapse_key = "likes";

        $tokens = [];
        // $apns_ids = [];
        $responseData = [];
       // $data= $request->all();
        $users= $this->user->id;
        // for Android
        if ($FCMTokenData = FCMToken::where('user_id',$users)->where('token','!=',null)->select('token')->get())
        {
            foreach ($FCMTokenData as $key => $value)
            {
                 $tokens[] = $value->token;
            }



        $likes = Like::where('liked_user_id', '=', $like->liked_user_id)->where('seen', '=', false)->get();
//            dd(LastKnown::where('user_id', '=', $like->liked_user_id)->first());
//            $lastKnownFull = LastKnown::where('user_id', '=', $like->liked_user_id);
//            $lastKnown = $lastKnownFull->first()->getLike($lastKnownFull->first()->user_id, $lastKnownFull->first()->like_id);
            $lastKnown = $likes->count();
        $msg = array
            (
                'tag' => $collapse_key,
                'title' =>$lastKnown . (($lastKnown >1)? " peoples": " person"). ' liked You\'r ' . (($lastKnown >1)? 'profile': (($likes->first()->picture_id == null)? "photo." : "answer.")),
                'data' => 'likes you',
                'sound' => 'default',
                "collapse_key" => $collapse_key,

            );
        $data = array
            (
                'type' => $collapse_key,
                'count'=> $lastKnown,
                "collapse_key" => $collapse_key,

            );

        $android = array(
                 'priority'=> 'high',

        );

//        dd($msg);
        if($tokens == null || sizeOf($tokens) == 0) return "No token found!!";
            $fields = array
            (
                "to"  => $tokens[0],
                'priority'=> 'high',
                "collapse_key" => $collapse_key,
                "notification"  => $msg,
                "data" => $data

            );

        //dd($fields);
        $responseData['android'] =[
                "result" => $this->send($fields)
            ];
        }
        return $responseData;
    }







    public function sendMessageNotification(){

        $collapse_key = "chat";

        $tokens = [];
        // $apns_ids = [];
        $responseData = [];
       // $data= $request->all();
        $users= $this->user->id;
        // for Android
        if ($FCMTokenData = FCMToken::where('user_id',$users)->where('token','!=',null)->select('token')->get())
        {
            foreach ($FCMTokenData as $key => $value)
            {
                 $tokens[] = $value->token;



            $msg = array
                (
                    'tag' => $collapse_key,
                    'title' => 'You have '. $this->user->UnreadCount($this->user->id) .' new messages',
                    'data' => 'likes you',
                    'sound' => 'default',
                    "collapse_key" => $collapse_key,

                );
            $data = array
                (
                    'type' => 'chat',
                    'count'=> $this->user->UnreadCount($this->user->id) ,
                "collapse_key" => $collapse_key,

                );

            $android = array(
                     'priority'=> 'high',
            );

            if($tokens == null || sizeOf($tokens) == 0) return "No token found!!";
            $fields = array
            (
                'to'  => $tokens[0],
                'notification'  => $msg,
                'data' => $data,
                'collapse_key' => $collapse_key
            );

        //dd($fields);
        $responseData['android'] =[
            "result" => $this->send($fields)
        ];
    }
    }
    return $responseData;
    }






    public function sendNewMatchNotification(Match $matches){

        $collapse_key = "match";
        $tokens = [];
        // $apns_ids = [];
        $responseData = [];
       // $data= $request->all();
        $users= $this->user->id;
        // for Android
        if ($FCMTokenData = FCMToken::where('user_id',$users)->where('token','!=',null)->select('token')->get())
        {
            foreach ($FCMTokenData as $key => $value)
            {
                 $tokens[] = $value->token;
            }


        $matches = Match::Matches($this->user->id)->where('seen', '=', 0)->get();

        $msg = array
            (
                'tag' => $collapse_key,
                'title' =>'You have ' . $matches->count() . (($matches->count() >1)? "new matches": "new match."),//. (($matches->count() >1)? 'profile': (($likes->first()->picture_id == null)? "picture" : "answer")),
                'data' => 'new matches',
                'sound' => 'default',
                "collapse_key" => $collapse_key,


            );
        $data = array
            (
                'type' => 'match',
                'count'=> $matches->count(),
                "collapse_key" => $collapse_key,

            );

        $android = array(
                 'priority'=> 'high',

        );
        if($tokens == null || sizeOf($tokens) == 0) return "No token found!!";
        $fields = array
            (
                'to'  => $tokens[0],
                'notification'  => $msg,
                'data' => $data,
                'collapse_key' => $collapse_key
            );

        //dd($fields);
        $responseData['android'] =[
            "result" => $this->send($fields)
        ];
    }
    return $responseData;
    }





    public function sendPaymentInformation(Payment $paymentInfo){

            $collapse_key = "payment";
            $tokens = [];
            // $apns_ids = [];
            $responseData = [];
        // $data= $request->all();
            $users= $this->user->id;
            // for Android
            if ($FCMTokenData = FCMToken::where('user_id',$users)->where('token','!=',null)->select('token')->get())
            {
                foreach ($FCMTokenData as $key => $value)
                    {
                        $tokens[] = $value->token;
                    }
                    // define('AAAAS5D_ibI:APA91bH_ilPYA2qnNG7pbKSLlkm3c5r6DaoEJHxIAd-LYAZPdZrhpQJDU5xHIH8lReY-YkoR_VLgfuY-x9yXC1W6oH6BaXME-mnCeU_gar5c_Pu7LRYo1vbPu2C5ufjG4s01g7dT7Bgn',
                    // 'AIzaSyBaEgYjDEwU8ifDjVCpaJWsvgzLzWvntGA' );

            $msg = array
                (
                    'tag' => $collapse_key,
                    'body' =>'Dear '. $this->user->first_name . " you have successfully bought ". $paymentInfo->paymentType->name . ". Your membership days will expire after " . $paymentInfo->paymentType->number_of_days . " days.",//. (($matches->count() >1)? 'profile': (($likes->first()->picture_id == null)? "picture" : "answer")),
                    'title' => "Payment Approved",
                    'data' => 'successfully paid',
                    'sound' => 'default',
                    "collapse_key" => $collapse_key,
                );

                // dd($msg);

            $data = array
                (
                    'type' => 'payment',
                    'payment_type'=> ''. $paymentInfo->paymentType->name,
                    "collapse_key" => $collapse_key,
                );


            $android = array(
                    'priority'=> 'high',
            );

            if($tokens == null || sizeOf($tokens) == 0) return "No token found!!";
            $fields = array
                (
                    'registration_ids'  => $tokens[0],
                    'notification'  => $msg,
                    'data' => $data,
                    'collapse_key' => $collapse_key
                );

            //dd($fields);
            $responseData['android'] =[
                "result" => $this->send($fields)
            ];
        }
        return $responseData;
    }






    public function sendUnMatchNotification(){

        $collapse_key = "unmatch";

        $tokens = [];
        // $apns_ids = [];
        $responseData = [];
       // $data= $request->all();
        $users= $this->user->id;
        // for Android
        if ($FCMTokenData = FCMToken::where('user_id',$users)->where('token','!=',null)->select('token')->get())
        {
            foreach ($FCMTokenData as $key => $value)
            {
                 $tokens[] = $value->token;
            }

        $msg = array
            (
                'tag' => $collapse_key,
                'sound' => 'default',
                "collapse_key" => $collapse_key,

            );
        $data = array
            (
                'type' => 'unmatch',
                "collapse_key" => $collapse_key,

            );
        $android = array(
                 'priority'=> 'high',
        );
            if($tokens == null || sizeOf($tokens) == 0) return "No token found!!";
            $fields = array
            (
                'registration_ids'  => $tokens,
                'data' => $data,
                'collapse_key' => $collapse_key
            );

        //dd($fields);
        $responseData['android'] =[
            "result" => $this->send($fields)
        ];
    }
    return $responseData;
    }


}
