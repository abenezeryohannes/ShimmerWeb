<?php

namespace App\Http\Resources;

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
            'id: ' =>$this->id,
            'First Name: ' => $this->first_name,
            'sex: ' => $this->sex,
            'Phone Number: ' => $this->phone_number,
        ];
    }
}
