<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Picture;
class PicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::all();

        foreach($users as $user){
            for($i =0;$i<6;$i++){
                $picture = new Picture();
                $picture->user_id = $user->id;
                $picture->name = strtolower($user->first_name) . ($i+1) . ".jpg";
                $picture->order = $i;
                $picture->save();
            }
        }
        
    }
}
