<?php

namespace App\Http\Resources\FindPeopleResource;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileFPResource extends JsonResource
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
            'user_id' =>$this->user_id,
            'first_name'=>($this->user->first_name == null)?null : strtok($this->user->first_name, ' '),
            'phone_number'=>$this->user->phone_number,
            'sex' => $this->sex,
            'age' => $this->age,
            'height_id' => $this->height_id,
            'work' => $this->work,
            'school' => $this->school,
            'relationship_type_id' => $this->relationship_type_id,
            'kid_id' => $this->kid_id,
            'family_plan' => $this->preference->family_plan_id,//$this->family_plan_id;
            'education_id' => $this->education_id,
            'drink_id' => $this->drink_id,
            'smoke_id' => $this->smoke_id,
            'question_and_answer' => Q_and_AFPResource::collection($this->answers),
            'pictures' => PictureFPResource::collection( $this->pictures),
            'location' => new LocationFPResource($this->location)
          ];
    }
}
