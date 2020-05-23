<?php

use Illuminate\Database\Seeder;
use App\Preference;
use App\Religion;
use App\User;
use App\Height;
use App\Kid;
use App\Education;
use App\Profile;
use App\RelationshipType;
use App\Smoke;
use App\Drink;
//use App\Language;

use App\FamilyPlan;
class PreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $religion_id = Religion::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $education_id = Education::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $relationship_type_id = RelationshipType::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $smoke_id = Smoke::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $drink_id = Drink::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $family_plan_id = FamilyPlan::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $kid_id = Kid::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        $max_height = Height::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
    
        
        $users = User::all();
        // $sex = ["Man","Woman","Both"];
        foreach($users as $user){
            $preference  = new Preference();
            $preference->user_id = $user->id;
            $sex = ($user->profile->sex == "Man")? "Woman":"Man";
            $preference->sex = $sex;
            $preference->min_height_id = 1;
            $preference->max_height_id = $max_height;
            $preference->min_age =18;
            $preference->max_age =100;
            
            $preference->kid_id = $kid_id;
            $preference->family_plan_id =  $family_plan_id;
            
            $preference->drink_id = $drink_id;
            $preference->education_id = $education_id;
            $preference->religion_id = ($religion_id);
            $preference->smoke_id = $smoke_id;
            $preference->relationship_type_id = $relationship_type_id;

            
            //$preference->religion_id = rand(1, 8);
            //$preference->education_id = rand(1, 4);
            //$preference->hometown = Str::random(5);
            //$preference->politic_id = rand(1, 5);
            //$preference->drinking = rand(1, 2) == 1? true:false;
            //$preference->smoking = rand(1, 2) == 1? true:false;

            $preference->save();
        }


    }
}
