<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use App\Answare;

class AnswaresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $questions = array(
            "The award I should be nominated for",
            "I’m actually legitimately bad at",
            "What I wanted to be when I grow up",
            "I’ll know I found the one when",
            "I’ll know I found the one when",
            "My Childhood Crush",
            "The Dorkiest thing about me is",
            "I’ll fall for you if",
            "I won't shut up about",
            "I bet you can’t",
            "I’m convinced that"
        );
        $answers = array(
            "",
            "Running away from my responsibilities. AND it feels good 😀",
            "Forgetting to call my Grandma. I just can’t stop thinking about that woman!",
            "Ice cream taster, dog peter, or pillow fighter.",

            "I don’t have to work anymore.",
            "When we adopt 30 puppies and keep bringing them on",
            "Tarzan, no doubt!",
            "saying calc-u-later as a goodbye.",
            "You are moody and ever-so-slightly narcissistic.",
            "Anything. I just won't shut up",
            "Understand why you are still reading this. JK! I bet you can’t wait to meet me.",
            "All my exes still love me."

        );

        foreach($users as $user){
            
            
            $randomQuestion = rand(1, sizeof($questions)-1);
            $answare1 = new Answare();
            $answare1->user_id = $user->id;
            $answare1->question_id = $randomQuestion;
            $answare1->text = $answers[$randomQuestion];
            $answare1->order = 1;
            $answare1->save();
            
            $before = $randomQuestion;

            while($before== $randomQuestion)
            $randomQuestion = rand(1, sizeof($questions)-1);
           
            $answare2 = new Answare();
            $answare2->user_id = $user->id;
            $answare2->question_id = $randomQuestion;
            $answare2->text = $answers[$randomQuestion];
            $answare2->order = 2;
            $answare2->save();
           
           
            $beforeBefore = $randomQuestion;
             while($before== $randomQuestion || $beforeBefore == $randomQuestion)
                $randomQuestion = rand(1, sizeof($questions)-1);
            
            $answare3 = new Answare();
            $answare3->user_id = $user->id;
            $answare3->question_id = $randomQuestion;
            $answare3->text = $answers[$randomQuestion];
            $answare3->order = 3;
            $answare3->save();
            
   
        }     
    }
}
