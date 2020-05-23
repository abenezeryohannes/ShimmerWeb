<?php

namespace App\Http\Resources\PaymentResource;

use Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Http\Resources\Json\ResourceCollection;
class Payment extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date_expire = Carbon::parse($this->expiration_date);
        
        return [ 
            'id' => $this->id,
            'payment_type' => new PaymentType($this->paymentType),
            'payed_through' => $this->payed_through,
            // 'recite' => new Recite($this->recite),
            'expiration_date' => $this->expiration_date//->format('F d Y')
        ];
        
       
    }

    public static function collection($resource){
        return new UserPayment($resource, get_called_class());
    }
    

}
