<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(KidsTableSeeder::class);
         $this->call(HeightsTableSeeder::class);
         $this->call(RelationshipTypesTableSeeder::class);

         $this->call(EducationsTableSeeder::class);
         $this->call(LocationsTableSeeder::class);
         $this->call(ReligionsTableSeeder::class);


         $this->call(FamilyPlansTableSeeder::class);
         $this->call(DrinksTableSeeder::class);
         $this->call(SmokesTableSeeder::Class);


         $this->call(QuestionsTableSeeder::class);
         $this->call(AnswaresTableSeeder::class);
         $this->call(ProfilesTableSeeder::class);
         $this->call(PreferencesTableSeeder::class);
         $this->call(PicturesTableSeeder::class);
        //  $this->call(LikesTableSeeder::class);



        //  $this->call(MatchesTableSeeder::class);
         $this->call(MessagesTableSeeder::class);
         $this->call(PaymentTypesTableSeeder::class);
         $this->call(ElloScoresTableSeeder::class);
         $this->call(LastTimeLoggedinsTableSeeder::class);

    }
}
