<?php

use Illuminate\Database\Seeder;
use App\Politic;
class PoliticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $politic1 = new Politic();
        $politic1->name = "Libral";
        $politic1->save();

        $politic2 = new Politic();
        $politic2->name = "Moderate";
        $politic2->save();

        $politic3 = new Politic();
        $politic3->name = "Conservative";
        $politic3->save();


        $politic4 = new Politic();
        $politic4->name = "Other";
        $politic4->save();

        $politic5 = new Politic();
        $politic5->name = "Prefer not to say";
        $politic5->save();
    }
}
