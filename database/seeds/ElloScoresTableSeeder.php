<?php

use Illuminate\Database\Seeder;
use App\User;
use App\ElloScore;

class ElloScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        $users = User::all();
        // $sex = ["Man","Woman","Both"];
        foreach($users as $user){
            $elloScore = new ElloScore();
            $elloScore->user_id = $user->id;
            $elloScore->swipe_count = 0;
            $elloScore->like_count = 0;
            $elloScore->final_score = 1;
            $elloScore->save();
        }
    }
}
