<?php

use App\LastKnown;
use Illuminate\Database\Seeder;
use App\User;
use App\Setting;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = array(
            "Betty",
            "Eden",
            "Senait",
            "Frehiwot",
            "Hawi",
            "Elias",
            "Nebiyu",
            "Abenezer",
            "Yohannes",
            "Yiwosin",
            "Eyob",
            "Tinsae",
        );

        for($i = 0;$i<sizeof($names);$i++){
            $user = new User();
            $user->phone_number = "910111" . $i;
            $user->first_name = $names[$i];
            // if($i<7)
            // $user->sex = "Woman";
            // else $user->sex = "Man";
            $user->email = $names[$i] . rand(1, 100) ."@gmail.com";
            $user->save();

            $lastKnown = new LastKnown();
            $lastKnown->user_id = $user->id;
            $lastKnown->save();

        }
        // $setting->free_likes_per_day = "10";
        // $setting->free_boosts_per_month = "0";
        // $setting->free_super_likes_per_month = "5";
        // $setting->boost_minutes = "180";
        // $setting->phone_number = "934333297";
        // $setting->bank_account = "1000197219387";
        // factory(User::class, 10)->create();
    }
}
