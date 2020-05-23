<?php

namespace App\Http\Resources\PaymentResource;

use Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneNumber extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $date_expire = Carbon::parse($this->expiration_date);
        

        return [ 
            'id' => $this->id,
            'phone_number' => $this->phone_number,
            'user_id' => $this->user_id,
            // 'recite' => new Recite($this->recite),
            // 'expiration_date' => $this->expiration_date//->format('F d Y')
        ];
        

    }
}
