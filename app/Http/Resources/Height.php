<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Height extends JsonResource
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
            'cm' => $this->cm,
            'feet' => $this->feet
        ];
    }
}
