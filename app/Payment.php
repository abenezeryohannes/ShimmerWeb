<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //


    public function paymentType()
    {
        return $this->belongsTo("App\PaymentType");
    }

}
