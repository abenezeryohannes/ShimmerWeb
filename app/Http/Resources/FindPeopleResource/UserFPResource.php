<?php

namespace App\Http\Resources\FindPeopleResource;

use Illuminate\Http\Resources\Json\JsonResource;

class UserFPResource extends JsonResource
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
            'first_name' => $this->first_name,
            'sex' => $this->sex,
            'question_and_answer' => Q_and_AFPResource::collection($this->whenLoaded('answares')),
        
        ];
    }
}
