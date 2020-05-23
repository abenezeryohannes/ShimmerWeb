<?php

use Illuminate\Database\Seeder;
use App\Kid;

//use Illuminate\Support\Facades\DB;

class KidsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // DB::table('kids')->insert([
        //     'name' => "Don't Have a Kid"
        // ]);

        // DB::table('kids')->insert([
        //     'name' => "Have a Kid"
        // ]);

        // DB::table('kids')->insert([
        //     'name' => "Prefer not to say"
        // ]);

        //factory(Kid::class, 3)->create();

        $kid1 = new Kid();
        $kid1->name = "Don't Have a Kid";
        $kid1->save();

        $kid2 = new Kid();
        $kid2->name = "Have a Kid";
        $kid2->save();
        
        $kid3 = new Kid();
        $kid3->name = "Prefer not to say";
        $kid3->save();
       
        
        
        

    }
}
