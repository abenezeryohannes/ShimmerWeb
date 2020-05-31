<?php

namespace App\Http\Resources\PaymentResource;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTypeFull extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'name' => $this->name,
            'type' => $this->type,
            'short_desc' => $this->short_desc,
            'long_desc' => $this->long_desc,
            'likes_per_day' => $this->likes_per_day,
            'super_likes_per_day' => $this->super_likes_per_day,
            'view_likes_per_day' => $this->view_likes_per_day,
            'boost_time' => $this->boost_minutes,
            'price' => $this->price,
            'number_of_days' => $this->number_of_days,
            'amount' => $this->amount
             ];
    }
}
