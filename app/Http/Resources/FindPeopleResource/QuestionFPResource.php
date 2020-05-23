<?php

namespace App\Http\Resources\FindPeopleResource;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionFPResource extends JsonResource
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
            'text' => $this->text,
             ];
    }
}
