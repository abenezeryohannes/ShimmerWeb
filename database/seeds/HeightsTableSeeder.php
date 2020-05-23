<?php

use Illuminate\Database\Seeder;
use App\Height;

class HeightsTableSeeder extends Seeder
{
    public function feet2cm($foot, $inch){
        $cm = 30.48 * $foot;
        $cm += 1.54 * $inch;
        return (int) $cm;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i =3;$i<8;$i++){
            for($j = 0;$j<12;$j++){
            $height = new Height();
            $cm = 30.48 * $i;
            $cm += 1.54 * $j;
            $height->cm =$cm;
            $feet = (string) $i;
            $inch = (string) $j;
            $height->feet =$feet."'".$inch;
            $height->save();
            }
        }

    }
    //1foot = 30.48cm
    //1inch = 1.54 centimeters

    function cm2feet($cm)
        {
            $inches = $cm/2.54;
            $feet = intval($inches/12);
            $inches = $inches%12;
            return sprintf('%d\' %d\"', $feet, $inches);
        }

    

}