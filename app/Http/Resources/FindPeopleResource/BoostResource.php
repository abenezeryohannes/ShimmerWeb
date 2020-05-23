<?php

namespace App\Http\Resources\FindPeopleResource;
use Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BoostResource extends JsonResource
{
    /** bety hawi eden senait
     * hawi bety eden senait
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $expiration_date = Carbon::parse($this->expiration_date);
        $start_time = Carbon::parse($this->start_time);

        return [ 
            'id' => $start_time->toDateTimeString(),
            'boost_time' => $this->boost_time,
            'expiration_date' => $expiration_date->toDateTimeString(),
            ];
    }
}
