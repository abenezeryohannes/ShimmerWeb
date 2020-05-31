<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Telegram extends JsonResource
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
            'user_id' => $this->user_id,
            'confirmation_code' => $this->confirmation_code,
            'confirmed' => $this->confirmed,
            'invitation_link' => $this->invitation_link,
            'total_approve' => $this->total_approve,
            'telegram_user_name' => $this->telegram_user_name,
        ];
    }
}
