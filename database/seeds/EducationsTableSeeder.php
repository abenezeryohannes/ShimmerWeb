<?php

use Illuminate\Database\Seeder;
use App\Education;

class EducationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education1 = new Education();
        $education1->name = "High School";
        $education1->save();

        $education2 = new Education();
        $education2->name = "UnderGraduate";
        $education2->save();

        $education3 = new Education();
        $education3->name = "PostGraduate";
        $education3->save();

        
        $education4 = new Education();
        $education4->name = "Prefer not to say";
        $education4->save();
    }
}
