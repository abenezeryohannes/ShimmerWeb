<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use App\User;
use App\UserReceipt;
use App\BankReceipt;
use App\PaymentType;
use App\Http\Resources\PaymentResource\UserPayment as UserPaymentResource;

class UserReceiptController extends Controller
{
    //


    public function checkReceipt(Request $r){
        
        $validatedUser = $r->validate([
            'user_id' => 'required',
            'sender' => 'required',
            'reference' => 'required',
            'date' => 'required'
        ]);
        $user = User::where("id", "=", $r['user_id'])->first();
        if($user == null) return response()->json(["status"=>"failure", "message"=>"User Not Logged In"]);



        $userReciept = new UserReceipt();
        $userReciept->user_id = $user->id;
        $userReciept->sender = $r->sender;
        $userReciept->reference = $r->reference;
        $userReciept->date = $r->date;
        // $userReciept->payed_amount = 25;
        $userReciept->save();
        // return $userReciept;

        $bankReciept = BankReceipt::
        where('sender', '=', $userReciept->sender)
        ->where('reference', '=', $userReciept->reference)
        ->where('date', '=', $userReciept->date)
        ->where('valid', '=', true)->first();


        if($bankReciept == null){
            return Response()->json(["status"=>"We will approve soon!", "message"=>"You will get notification as soon as we confirm this payment. Thanks."]);
        }else{
            $userReciept->confirmed = true;
            $userReciept->save();
            $bankReciept->valid = false;
            $bankReciept->save();



            $payment_type = PaymentType::where('price', '=', $bankReciept->payed_amount)->first();

            if($payment_type == null) return response()->json(['status'=> 'No plan with this payment amount!', "message"=>"Sorry there is no plan that fit these payment amount please contact our team through our telegram account @shimmer_customer_service."]);
    
            // dd($user_id);
    
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->payment_type_id = $payment_type->id;
            $today = Carbon::now();
            $payment->expiration_date = $today->addDays($payment_type->date_length);
            $payment->save();


            return Response()->json(["status"=>"Successful", 
            "data"=> UserPaymentResource::make($payment)->user($user->id),
            "message"=> "You'r payment is successfull your membership period starts now. Thanks."]);
        }





    }
}
