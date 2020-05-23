<?php

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
        }
        $setting  = new Setting();
        $setting->save();
        // factory(User::class, 10)->create();
    }
}
