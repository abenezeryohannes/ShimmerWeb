<?php

use Illuminate\Database\Seeder;
use App\FamilyPlan;
class FamilyPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $familyplan1 = new FamilyPlan();
        $familyplan1->name = "Don't want kids";
        $familyplan1->save();

        
        $familyplan2 = new FamilyPlan();
        $familyplan2->name = "want kids";
        $familyplan2->save();

        $familyplan3 = new FamilyPlan();
        $familyplan3->name = "Open to kids";
        $familyplan3->save();
        
        $familyplan4 = new FamilyPlan();
        $familyplan4->name = "Prefer not to say";
        $familyplan4->save();
    }
}
