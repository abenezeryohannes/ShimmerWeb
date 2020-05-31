<?php

use Illuminate\Database\Seeder;
use App\Question;
use Faker\Generator as Faker;
class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
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
       for($x = 0; $x < sizeof($questions); $x++){
           $question = new Question();
           $question->text = $questions[$x];
           $question->suggestion = $answers[$x];
           $question->save();
       } 



   //     factory(Question::class, 30)->create();
    }
}
