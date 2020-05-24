<?php

namespace App\Http\Resources\LikePeopleResource;

use App\Http\Resources\FindPeopleResource\Q_and_AFPResource;
use App\Http\Resources\FindPeopleResource\PictureFPResource;

use Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class LikersResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $time = (Carbon::parse($this->created_at));//Carbon::now()->diffInMilliSeconds
       
        return [
            'id'=>$this->id,
            'question_and_answer' => new Q_and_AFPResource($this->answare),
            'picture' => new PictureFPResource($this->picture),
            'comment' => $this->comment,
            'seen' => $this->seen,
            'super_like' => $this->super_like,
            'time' => $time->toDateTimeString()
            ];
    }


}
