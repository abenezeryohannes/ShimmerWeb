<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon;
class UnmatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $time = Carbon::parse($this->created_at);
       
        return [
            'id' =>$this->id,
            'match_id' => $this->match_id,
            'user_id_1' => $this->user_id_1,
            'user_id_2' => $this->usre_id_2,
            'unmatcher_id' => $this->unmatcher_id,
            'created_at' => $time
             ];
    }
}
