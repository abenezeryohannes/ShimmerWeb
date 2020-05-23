<?php

namespace App\Http\Resources\FindPeopleResource;

use Illuminate\Http\Resources\Json\JsonResource;

class Q_and_AFPResource extends JsonResource
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
            "question" => new QuestionFPResource($this->question),
            "answer" => new AnswerFPResource($this)
             ];
    }
}
