<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;
use App\User;
use Carbon;
use App\LastTimeLoggedin;
class SessionController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function sessionStart(Request $request)
    {
        //add to last_time logedin
        //get the last session if there is any
        //if session end is not null add new sesttion
        //else set the session end time to now and add new sesstion
        //if there is no session saved add new sesstion

         $validatedUser = $request->validate([
                'user' => 'required',
                'time' => 'required',
            ]);

            if($request['time'] == null)
                $time = Carbon::now()->toDateTimeString();
            else
                $time = $date = Carbon::parse($request["time"])->toDateTimeString();

            $user = User::where('id', '=', $request['user'])->first();

            if($user == null) return "No user with this id: " . $request['user'];

            $lastSession = Session::where('user_id', '=', $user->id)->orderBy('id', 'desc')->first();

            if($lastSession!=null)
                if($lastSession->session_end == null){
                        $lastSession->session_end = $time;
                        $lastSession->save();
                 }

             $newSession = new Session();
             $newSession->user_id = $user->id;
             $newSession->session_start = $time;
             $newSession->save();




            //last time logged in
            $lastTimeLoggedIn = LastTimeLoggedin::where('user_id', '=', $user->id)->first();
            if($lastTimeLoggedIn != null){
                $lastTimeLoggedIn->time = $time;
                $lastTimeLoggedIn->save();

            }else{
                $lastTimeLoggedIn = new LastTimeLoggedin();
                $lastTimeLoggedIn->time = $time;
                $lastTimeLoggedIn->user_id = $user->id;
                $lastTimeLoggedIn->save();
            }
            

            return response()->json(["status"=>"successful"]);


    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function sessionEnd(Request $request)
    {
        
        $validatedUser = $request->validate([
            'user' => 'required',
            'time' => 'required',
        ]);

        $user = User::where('id', '=', $request['user'])->first();
        if($request['time'] == null)
               $time = Carbon::now()->toDateTimeString();
        else
               $time = $date = Carbon::parse($request["time"])->toDateTimeString();

        if($user == null) return "No user with this id";

        $lastSession = Session::where('user_id', '=', $user->id)->orderBy('id', 'desc')->first();

        if($lastSession!=null){
            if($lastSession->session_end == null){
                $lastSession->session_end = $time;
                $lastSession->save();
            }
        }

        return response()->json(["status"=>"successful"]);

    }


}
