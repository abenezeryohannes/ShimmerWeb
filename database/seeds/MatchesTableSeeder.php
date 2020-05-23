<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Match;
class MatchesTableSeeder extends Seeder
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
        $amount = sizeof($users);
        foreach($users as $user){
            $count = 0;
        foreach($users as $user2){
            if($user->id < $user2->id){
                $count+=1;
                $match = new Match();
                $match->user_id_1 = $user->id;
                $match->user_id_2 = $user2->id;
                // $match->seen = ($count == 0)? false : true;
                $match->save();
                if($count >= $amount/2) break;
            }
        }
        }
    }
}
