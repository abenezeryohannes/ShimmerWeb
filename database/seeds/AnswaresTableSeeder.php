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
            "I'm looking for",
            "I get along best with people who",
            "I want someone who",
            "I won't shut up about",
            "My greatest strength",
            "Let's debate this topic",
            "Try to guess this about me",
            "Believe it or not, I",
            "Do you agree or disagree that",
            "Don't hate me If I",
            "Fact about me that surprises people",
            "I go crazy for",

            "Teach me something about",
            "I'm weirdly attracted to",
            "You'll know i like you if",
            "The one thing you should know about me is",
            "You should not go out with me if",
            "worst idea i ever had",
            "we're tha same type of wierd if",
            "A life goal of mine",
            "Never have I ever",
            "I'll Know I've found the one when",
            "I'll introduce you to my family if",
            "I take pride in",
            "Something that's non-negotiable for me is",
           
        );
        $answers = array(
            "Someone funny & smart, who loves live music as much as I do.",
            "Think \"irtib\" is the best fast food :)",

            "Helps me to achieve all my life goals and make me believe in myself.",
            "My new workout class that I don't hate yet.",
            
            "I'm really skilled at Rock, Paper, Scissors.",
            "Ex. Smart phone is a higher invention than tv.",
            "what is my favorite place to chill? Hint: One of my photos might give it away",
            "Shared a taxi with Beyonce.",
            "Ex. Betoch is the greatest sitcom of all time.",
            "Say I don't want french fries. then eat all of yours :)",
            "I've never had a fast food hamburger in my life.",
            "90's music.",


            "Music, My tastes never progressed past \"High School Musical\"",
            "Great use of emojis",
            "I let you Facetime with my dog.",
            "I love my dog Zoey and she will probably be joining us on all of our dates.",
            "Your not willing to bet on chess game.",
            "Dying my hair blonde And bleaching my eyebrows to match.",
            "Long menus stress you out.",
            "To go on Shark Tank.",
            "Been In Bahr dar.",
            "We laugh like Jim and Pam.",
            "You can make my gradma laugh.",
            "Being the first in my family to graduate from college.",
            "If titanic comes on TV we have to stop everything and watch.",


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
