<?php

use Illuminate\Database\Seeder;
use App\Drink;
class DrinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drink1 = new Drink();
        $drink1->name = "Yes";
        $drink1->save();
        $drink2 = new Drink();
        $drink2->name = "No";
        $drink2->save();
        $drink3 = new Drink();
        $drink3->name = "Somethimes";
        $drink3->save();
        $drink4 = new Drink();
        $drink4->name = "Prefer not to say";
        $drink4->save();
    }
}
