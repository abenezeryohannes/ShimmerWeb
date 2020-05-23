<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Message;
class MessagesTableSeeder extends Seeder
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
            $count = -1;
            foreach($users as $user2){
                // $count+=1;
                // if($count%2==0)continue;
                // if($user->id == $user2->id)continue;
                // $match = Match::GetMatch($user->id, $user->id2)->first()->id;
                // $message = new Message();
                // $message->match_id = $user->id;
                // $message->sender_id = $user->id;
                // $message->reciever_id = $user2->id;
                // $message->message = Str::random(20);
                // $message->seen = false;
                // $message->save();
            }
        }
    }
}
