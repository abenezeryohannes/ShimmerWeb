<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Q_and_A extends JsonResource
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
            "question" => new Question($this->question),
            "answer" => new Answer($this)
             ];
    }
}
