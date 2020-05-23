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
       for($x = 0; $x < sizeof($questions); $x++){
           $question = new Question();
           $question->text = $questions[$x];
           $question->suggestion = $answers[$x];
           $question->save();
       } 



   //     factory(Question::class, 30)->create();
    }
}
