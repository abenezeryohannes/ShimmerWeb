<?php

namespace App\Http\Controllers;

use App\LastKnown;
use App\PaymentType;
use App\Payment;
use Carbon;
use App\User;
use App\Phonenumber;
use App\Http\Resources\PaymentResource\Payment as PaymentResource;
use App\Http\Resources\PaymentResource\UserPayment as UserPaymentResource;
use App\Http\Resources\PaymentResource\PaymentType as PaymentTypeResource;
use App\Http\Resources\PaymentResource\PaymentTypeFull as PaymentTypeFullResource;
use App\Http\Resources\PaymentResource\Recite as ReciteResource;

use Illuminate\Http\Request;
class PaymentController extends Controller
{
    public function getPaymentTypes()
    {
        $payment_types = PaymentType::all();
        return PaymentTypeResource::collection($payment_types);
    }

    public function getPaymentTypesof(Request $request)
    {
        $validatedUser = $request->validate([
            'type' => 'required'
            ]);

        $payment_types = PaymentType::where("type", '=', $request['type'])->get();
        return PaymentTypeResource::collection($payment_types);
    }

    public function getFullPaymentType(Request $request)
    {
        $paymentID = $request['payment_id'];
        if($paymentID==null) return "No payment id sent";
        $payment_type = PaymentType::where('id', '=', $paymentID)->first();
        return new PaymentTypeFullResource($payment_type);
    }


    public function getFullPaymentTypes(Request $request)
    {
        $payment_types = PaymentType::all();
        return PaymentTypeFullResource::collection($payment_types);
    }





    public function getUserActivePayments(Request $request)
    {
        $user_id = $request['user_id'];

        $user = User::where('id', '=', $user_id);

        if($user == null ) return "User is null";

        // dd($user->);

        $payment = Payment::where('user_id', '=', $user_id)->where('expiration_date', '>', Carbon::now())->get();

        $lastKnown = LastKnown::where('user_id', '=', $request['user_id'])->first();
        $lastKnown->payment_id = ($lastKnown->payment_id>$payment->last()->id)?$lastKnown->payment_id:$payment->last()->id;
        $lastKnown->save();
        // dd($payment);
        return UserPaymentResource::make($payment)->user($request['user_id']);//Response()->json(Match::GetUnseenCount(1, 2));//

    }



    public function pay_by_phone(Request $request)
    {

        $phone_number = $request['phone'];
        // $phone_number = $phone_number;
        // dd($user_id);

        $payed_amount = $request['payed_amount'];

        // dd($phone_number);

        $user = User::where('phone_number', '=', $phone_number)->first();

        //if user phone number is null go to other phone numbers linked to the account

        // dd($phone_number);
        if($user == null){
            // dd($phone_number);
            $phone = Phonenumber::where('phone_number', '=', $phone_number)->first();
            // dd($phone);
            if($phone == null) return response()->json(['status'=> 'This phone number is not linked to any account']);
            $user = User::find($phone->user_id);
            if($user == null){
                return response()->json(['status'=> 'No phone number linked with this account!']);
            }
        }


        if($user == null) return response()->json(['status'=> 'No user with this id!']);

        $payment_type = PaymentType::where('price', '=', $payed_amount)->first();

        if($payment_type == null) return response()->json(
            ['status'=> 'No payment type with this id!']
        );


        //dd($user->id);

        //$paymentPrev = Payment::where('user_id', '=', $user->id)->delete();

        // dd($user);
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->payment_type_id = $payment_type->id;
        $today = Carbon::now();
        //return $today;
        //return ($today->addDays($payment_type->date_length));
        $payment->expiration_date = $today->addDays($payment_type->date_length);
        $payment->save();

        $spn = new SendPushNotificationController($user);
        $spn->sendPaymentInformation($payment);

        return new PaymentResource($payment);


    }




    public function pay_by_cbe(Request $request)
    {

        $user_id = $request['user'];
        // dd($user_id);

        $payed_amount = $request['payed_amount'];

        $user = User::where('id', '=', $user_id)->first();

        $phone_number = $request['phone_number'];
        if($user == null){
            $phone = Phonenumber::where('phone_number', '=', $phone_number)->first();
            if($phone == null) return response()->json(['status'=> 'This phone number is not linked to any account']);
            $user = User::find($phone->id);
            if($user == null){
                return response()->json(['status'=> 'No phone number linked with this account!']);
            }
        }

        $payment_type = PaymentType::where('price', '=', $payed_amount)->first();

        if($payment_type == null) return response()->json(['status'=> 'No payment type with this id!']);

        // dd($user_id);


        $paymentPrev = Payment::where('user_id', '=', $user_id)->delete();

        $payment = new Payment();
        $payment->user_id = $user_id;
        $payment->payment_type_id = $payment_type->id;
        $today = Carbon::now();
        //return $today;
        //return ($today->addDays($payment_type->date_length));
        $payment->expiration_date = $today->addDays($payment_type->date_length);
        $payment->save();



        $spn = new SendPushNotificationController($user);
        $spn->sendPayment($payment);

        return new PaymentResource($payment);

    }


}
