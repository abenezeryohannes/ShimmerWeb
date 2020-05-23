<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
use App\LastTimeLoggedin;
class LastTimeLoggedinsTableSeeder extends Seeder
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
            $lastTimeLogin = new LastTimeLoggedin();
            $lastTimeLogin->user_id = $user->id;
            $lastTimeLogin->time = Carbon::now()->toDateTimeString();
            $lastTimeLogin->save();
        }
    }
}
