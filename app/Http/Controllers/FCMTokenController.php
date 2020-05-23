<?php

namespace App\Http\Controllers;

use App\FCMToken;
use Illuminate\Http\Request;

class FCMTokenController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        // dd($data);
        // $userId = Auth::id();

        $userId = $request['user_id'];

        $fcm = FCMToken::where('user_id', '=', $request['user_id'])->first();
        if($fcm != null){
            if($fcm->token == $request['regID']){
                return response()->json(['status' => 'Success'], 200);
            }else{
                $fcm = new FCMToken();
                $fcm->user_id = $request['user_id'];
                $fcm->token = $request['regID'];
                $fcm->save();
            }
        }else
            {
                $fcm = new FCMToken();
                $fcm->user_id = $request['user_id'];
                $fcm->token = $request['regID'];
                $fcm->save();
            }
        if ($fcm) 
        {
                return response()->json(['status' => 'Success'], 200);
        } 
        else 
        {
                return response()->json(['status' => 'Something went wrong!!'], 400);                
        } 
	        
    }
}
