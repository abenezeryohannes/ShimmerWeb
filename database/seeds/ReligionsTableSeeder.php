<?php

use Illuminate\Database\Seeder;
use App\Religion;
class ReligionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $religion1 = new Religion();
       $religion1->name = "Atheist";
       $religion1->save();

       
       $religion2 = new Religion();
       $religion2->name = "Agnostic";
       $religion2->save();

       
       $religion3 = new Religion();
       $religion3->name = "Catholic";
       $religion3->save();

       
       $religion4 = new Religion();
       $religion4->name = "Christian";
       $religion4->save();

       
       $religion5 = new Religion();
       $religion5->name = "Muslim";
       $religion5->save();

       
       $religion6 = new Religion();
       $religion6->name = "Spritual";
       $religion6->save();

       
       $religion7 = new Religion();
       $religion7->name = "Other";
       $religion7->save();

       $religion8 = new Religion();
       $religion8->name = "Prefer not to say";
       $religion8->save();

    }
}
