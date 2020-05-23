<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //subscribtion plans
        $paymentType1 = new PaymentType();
        $paymentType1->name = "Weekly Plan";
        $paymentType1->type = "subscribtion";
        $paymentType1->short_desc = "1 Week Plan short describtion";
        $paymentType1->long_desc = "1 Week Plan long describtion";
        $paymentType1->likes_per_day = 1000000;
        $paymentType1->super_likes_per_day = 5;
        $paymentType1->view_likes_per_day = 100000;
        $paymentType1->boost_minutes = 1;
        $paymentType1->number_of_days = 7;
        $paymentType1->price = 30;
        $paymentType1->save();

        
        $paymentType2 = new PaymentType();
        $paymentType2->name = "Monthly Plan";
        $paymentType2->type = "subscribtion";
        $paymentType2->short_desc = "1 Month Plan short describtion";
        $paymentType2->long_desc = "1 Month Plan long describtion";
        $paymentType2->likes_per_day = 1000000;
        $paymentType2->super_likes_per_day = 5;
        $paymentType2->view_likes_per_day = 100000;
        $paymentType2->boost_minutes = 2;
        $paymentType2->number_of_days = 30;
        $paymentType2->price = 30;
        $paymentType2->save();

        
        $paymentType3 = new PaymentType();
        $paymentType3->name = "3 Month Plan";
        $paymentType3->type = "subscribtion";
        $paymentType3->short_desc = "3 Month Plan short describtion";
        $paymentType3->long_desc = "3 Month Plan long describtion";
        $paymentType3->likes_per_day = 1000000;
        $paymentType3->super_likes_per_day = 5;
        $paymentType3->view_likes_per_day = 100000;
        $paymentType3->boost_minutes = 3;
        $paymentType3->number_of_days = 7;
        $paymentType3->price = 90;
        $paymentType3->save();



        //Boost plans
        $paymentType4 = new PaymentType();
        $paymentType4->name = "Boosts";
        $paymentType4->type = "boost";
        $paymentType4->short_desc = "Boosts short describtion";
        $paymentType4->long_desc = "Boosts long describtion";
        $paymentType4->likes_per_day = 0;
        $paymentType4->super_likes_per_day = 0;
        $paymentType4->view_likes_per_day = 0;
        $paymentType4->boost_minutes = 30;
        $paymentType4->number_of_days = 1;
        $paymentType4->price = 15;
        $paymentType4->save();


        $paymentType5 = new PaymentType();
        $paymentType5->name = "Boosts";
        $paymentType5->type = "boost";
        $paymentType5->short_desc = "Boosts short describtion";
        $paymentType5->long_desc = "Boosts long describtion";
        $paymentType5->likes_per_day = 0;
        $paymentType5->super_likes_per_day = 0;
        $paymentType5->view_likes_per_day = 0;
        $paymentType5->boost_minutes = 30;
        $paymentType5->number_of_days = 5;
        $paymentType5->price = 50;
        $paymentType5->save();
        

        $paymentType6 = new PaymentType();
        $paymentType6->name = "Boosts";
        $paymentType6->type = "boost";
        $paymentType6->short_desc = "5 Boosts short describtion";
        $paymentType6->long_desc = "5 Boosts long describtion";
        $paymentType6->likes_per_day = 0;
        $paymentType6->super_likes_per_day = 0;
        $paymentType6->view_likes_per_day = 0;
        $paymentType6->boost_minutes = 30;
        $paymentType6->number_of_days = 10;
        $paymentType6->price = 80;
        $paymentType6->save();
        


    }
}
