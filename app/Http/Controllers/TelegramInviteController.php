<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Telegram;
use App\User;
use App\TelegramInvite;


class TelegramInviteController  extends Controller
{
    //
    public function linkTelegramAccount(Request $request){

        $validatedUser = $request->validate([
            'user_id' => 'required',
            'tg_user_name' => 'required'
        ]);

        $new_confirmation_code = "1";//sha1(time());

        //check if user exist;
        
        $user = User::where("id", "=", $request['user_id'])->first();
        if($user == null) return response()->json(["status"=>"failure", "message"=>"User Not Logged In"]);

            $tg = TelegramInvite::where("telegram_user_name", "=", $request['tg_user_name'])->first();
            if($tg!=null){
                if($tg->user_id == $user->id){
                    //save confirmation code and send it
                    $tg->confirmation_code = $new_confirmation_code;
                    $tg->user_id = $user->id;
                    $tg->telegram_user_name = $request['tg_user_name'];
                }else{
                    if($tg->confirmed == 1)
                        return response()->json(["status"=>"failure", "message"=>"This telegram account is already linked with other account!"]);
                    else{

                            //save confirmation code and send it
                            $tg->confirmation_code = $new_confirmation_code;
                            $tg->user_id = $user->id;
                            $tg->telegram_user_name = $request['tg_user_name'];
                        }
                }
            }else{
                TelegramInvite::where('user_id', '=', $user->id)->delete();
                $tg = new TelegramInvite();
                $tg->confirmation_code = $new_confirmation_code;
                $tg->user_id = $user->id;
                $tg->telegram_user_name = $request['tg_user_name'];
                //save confirmation code and send it
            }

            $tg->save();
            return response()->json(["status"=>"successful", "data"=> new Telegram($tg)]);
            
    }




    

    public function confirmTg(Request $request){
        $validatedUser = $request->validate([
            'user_id' => 'required',
            'tg_user_name' => 'required',
            'code' => 'required'
        ]);

        $new_confirmation_code = "1";//sha1(time());

        //check if user exist;
        $user = User::where("id", "=", $request['user_id'])->first();
        if($user == null) return response()->json(["status"=>"failure", "message"=>"User Not Logged In"]);


        //check if telegram account is valid;
        $tg = TelegramInvite::where('user_id', '=', $user->id)->first();
        
        // dd($tg);s

        if($tg==null) return response()->json(["status"=>"failure", "message"=> "Your account is not linked to any telegram account yet!"]);
        
        if($tg->confirmation_code == $request['code']){
            $tg->confirmed = true;
            $tg->save();
            return response()->json(["status"=>"successful", "data"=> new Telegram($tg)]); 
        }
                    
        return response()->json(["status"=>"failure", "message"=> "Confirmation code doesn't match!"]);
    }

    public function getTg(Request $request){
        
        $validatedUser = $request->validate([
            'user_id' => 'required',
        ]);


        //check if user exist;
        $user = User::where("id", "=", $request['user_id'])->first();
        if($user == null) return response()->json(["status"=>"failure", "message"=>"User Not Logged In"]);


        $tg = TelegramInvite::where("user_id", "=", $request['user_id'])->first();
        
        return response()->json(["status"=>"successful", "data"=> new Telegram($tg)]);
    }


}
