<?php

use Illuminate\Database\Seeder;
use App\RelationshipType;
class RelationshipTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        $relationshipType1 = new RelationshipType();
        $relationshipType1->name = "Casual";
        $relationshipType1->save();


        
        $relationshipType2 = new RelationshipType();
        $relationshipType2->name = "Serious";
        $relationshipType2->save();

        $relationshipType3 = new RelationshipType();
        $relationshipType3->name = "hookup";
        $relationshipType3->save();

          
        $relationshipType4 = new RelationshipType();
        $relationshipType4->name = "Friends with benefit";
        $relationshipType4->save();

        $relationshipType5 = new RelationshipType();
        $relationshipType5->name = "Prefer not to say";
        $relationshipType5->save();
    }
}
