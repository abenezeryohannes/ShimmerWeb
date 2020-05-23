<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource\PhoneNumber;
use App\User;
use App\Phonenumber as Phones;

class PhonenumberController extends Controller
{
    //


    public function createPhoneNumber(Request $request){

        $validatedRequest = $request->validate([
            'user_id' => 'required',
            'phone_number' => 'required'
        ]);

        $user = User::where('id', '=', $request['user_id'])->first();
        if($user == null)return response()->json(["status"=>"failure", "message"=>"You didn't sign up!!"]);
        $deletePhone = Phones::where('phone_number', '=', $request['phone_number'])->where('user_id', '=', $user->id)->first();
        if($deletePhone !=null) return response()->json(["status"=>"failure", "message"=>"The number is already connected to your account!!"]);

        $phoneNumber = new Phones();
        $phoneNumber->user_id = $request['user_id'];
        $phoneNumber->phone_number = $request['phone_number'];
        $phoneNumber->save();
        return response()->json(["status"=>"successfull", "data"=> new PhoneNumber($phoneNumber)]);
    }

    public function deletePhoneNumber(Request $request){
        $validatedRequest = $request->validate([
            'user_id' => 'required',
            'phone_number' => 'required'
        ]);

        $user = User::where('id', '=', $request['user_id'])->first();
        if($user == null)return response()->json(["status"=>"failure", "message"=>"You didn't sign up!!"]);

        $deletePhone = Phones::where('phone_number', '=', $request['phone_number'])->where('user_id', '=', $user->id)->delete();

        if($deletePhone!=null)
        return response()->json(["status"=>"successfull"]);
        return response()->json(["status"=>"failure", "message"=> "Phone number connected to this account is already deleted."]);

    }



    public function getLinkedPhoneNumbers(Request $request){
         $validatedRequest = $request->validate([
                            'user_id' => 'required',
                        ]);
        $user = User::where('id', '=', $request['user_id'])->first();
       if($user == null)return response()->json(["status"=>"failure", "message"=>"You didn't sign up!!"]);
        $editPhone = Phones::where('user_id', '=', $user->id)->get();
        return PhoneNumber::collection($editPhone);
    }



    public function editPhoneNumber(Request $request){
        $validatedRequest = $request->validate([
                    'user_id' => 'required',
                    'prev_phone_number' => 'required',
                    'new_phone_number' => 'required'
                ]);
        $user = User::where('id', '=', $request['user_id'])->first();
        if($user == null)return response()->json(["status"=>"failure", "message"=>"You didn't sign up!!"]);


        $editPhone = Phones::where('phone_number', '=', $request['prev_phone_number'])->where('user_id', '=', $user->id)->first();
        $editPhone->phone_number = $request['new_phone_number'];
        $editPhone->save();
        return response()->json(["status"=>"successfull", "data"=> new PhoneNumber($editPhone)]);
    }


}
