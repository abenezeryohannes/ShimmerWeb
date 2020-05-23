<?php

use Illuminate\Database\Seeder;
use App\Profile;
use App\User;
class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $users = User::all();
        
        foreach($users as $user){
            $profile  = new Profile();
            $profile->user_id = $user->id;
            if($user->id<6)
            $profile->sex = "Woman";//rand(1, 2) == 1? "Man":"Woman";
            else
            $profile->sex = "Man";
            $profile->height_id =  rand(28, 40);
            $profile->completed =  100;

            $profile->kid_id = rand(1, 3);
            $profile->work = "Student";
            $profile->school = "Astu";
            $profile->job = "Learning";
            $profile->family_plan_id = rand(1, 4);
            $profile->relationship_type_id = rand(1, 2);
            $profile->religion_id = rand(1, 8);
            $profile->education_id = rand(1, 4);
            
            $profile->drink_id = rand(1, 4);
            $profile->smoke_id = rand(1, 4);
            // $profile->hometown = Str::random(5);
            $profile->age = rand(18, 40);

            $profile->save();
        }
    }
}
