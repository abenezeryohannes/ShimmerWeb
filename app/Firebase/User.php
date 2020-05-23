<?php

namespace App\Firebase;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'id: ' =>$this->iss,
            'First Name: ' => $this->aud,
            'Last Name: ' => $this->last_name,
            'Phone Number: ' => $this->phone_number,
        ];
    }
}
