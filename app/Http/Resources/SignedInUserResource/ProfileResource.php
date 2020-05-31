<?php

namespace App\Http\Resources\SignedInUserResource;

use App\Http\Resources\FindPeopleResource\Q_and_AFPResource as QandAFPResource;
use App\Http\Resources\FindPeopleResource\PictureFPResource as PictureFPResource;
use App\Http\Resources\FindPeopleResource\RelationshipTypeResources;
use App\Http\Resources\PaymentResource\Payment as PaymentInformation;
use App\Http\Resources\PaymentResource\PhoneNumber;
use App\Http\Resources\PaymentResource\UserPayment as UserPaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Payment;
use Carbon;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
      
        // dd($this->phonenumbers);
        // dd($payment);
        $payment = Payment::where('user_id', '=', $this->user_id)->where('expiration_date', '>', Carbon::now())->get();
        return [
            'user_id' =>$this->user_id,
            'telegram_user_name' => ($this->user->telegram ==null)? null : $this->user->telegram->telegram_user_name,
            'completed'=>$this->completed,
            'first_name'=>($this->user->first_name == null)?null : strtok($this->user->first_name, ' '),
            'full_name'=>($this->user->first_name),
            'phone_number'=>$this->user->phone_number,
            'facebook_id'=>$this->user->facebook_id,
            'sex' => $this->sex,
            'age' => $this->age,
            'height_id' => $this->height_id,
            'work' => $this->work,
            'school' => $this->school,
            'kid_id' => $this->kid_id,
            'family_plan' => $this->preference->family_plan_id,//$this->family_plan_id;
            'education_id' => $this->education_id,
            'drink_id' => $this->drink_id,
            'smoke_id' => $this->smoke_id,

            'job' => $this->job,
            'home_town' => $this->home_town,
            'religion_id' => $this->religion_id,
            'relationship_type_id' => $this->relationship_type_id,
            'location' => new LocationResource($this->location),
            'preference' => new PreferenceResource($this->preference),
            'question_and_answer' => QandAFPResource::collection($this->answers),
            'pictures' => PictureFPResource::collection( $this->pictures),
            'payment_info' => UserPaymentResource::make($payment)->user($this->user_id),
            'phone_numbers' => PhoneNumber::collection($this->phonenumbers)
          ];
    }
}
