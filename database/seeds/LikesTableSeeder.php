<?php

use App\Location;
use App\User;
use App\Like;
use App\Picture;
use App\Answare;
use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
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
        $users2 = User::all();

        $i = 0;
        foreach($users as $liker){
            foreach($users2 as $liked) {
                $like = new Like();
                $like->liker_user_id = $liker->id;
                $like->liked_user_id = $liked->id;
                $pictures = Picture::Where('user_id','=',$liked->id)->get();
                $like->notified = false;
                foreach ($pictures as $pic){
                    $like->picture_id = $pic->id;
                    if($i%2 == 0) $like->comment =  "This is a comment for picture " . $pic->name;
                    $like->save();
                }
                $like2 = new Like();
                $like2->liker_user_id = $liker->id;
                $like2->liked_user_id = $liked->id;
                $like2->notified = false;
                $answares = Answare::Where('user_id','=',$liked->id)->get();

                foreach ($answares as $ans) {
                    $like2->answare_id = $ans->id;
                    if($i%2 == 0) $like2->comment =  "This is a comment for answer " . $ans->text;
                    $like2->save();
                }
            }
        }





    }

}
