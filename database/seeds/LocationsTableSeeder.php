<?php

use Illuminate\Database\Seeder;
use App\Location;
use App\User;

class LocationsTableSeeder extends Seeder
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
            $location = new Location();
            $location->user_Id = $user->id;
            $location->latitude = rand(1, 40);
            $location->longitude = rand(1, 40);
            $location->save();
        }
    }
}
