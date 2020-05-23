<?php

namespace App\Http\Resources\SignedInUserResource;

use Illuminate\Http\Resources\Json\JsonResource;

class PreferenceResource extends JsonResource
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
            'max_height_id' => $this->max_height_id,
            'min_height_id' => $this->min_height_id,
            'min_age' => $this->min_age,
            'max_age' => $this->max_age,
            'sex' => $this->sex,
            'smoke_id' => $this->smoke_id,
            'drink_id' => $this->drink_id,
            'kid_id' => $this->kid_id,
            'family_plan_id' => $this->family_plan_id,
            'education_id' => $this->education_id,
            'religion_id' => $this->religion_id,
        ];
    }
}
