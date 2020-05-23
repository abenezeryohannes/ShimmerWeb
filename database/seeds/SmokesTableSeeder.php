<?php

use Illuminate\Database\Seeder;
use App\Smoke;
class SmokesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smoke1 = new Smoke();
        $smoke1->name = "Yes";
        $smoke1->save();
        $smoke2 = new Smoke();
        $smoke2->name = "No";
        $smoke2->save();
        $smoke3 = new Smoke();
        $smoke3->name = "Somethimes";
        $smoke3->save();
        $smoke4 = new Smoke();
        $smoke4->name = "Prefer not to say";
        $smoke4->save();
    }
}
