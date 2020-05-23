<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoronaController extends Controller
{
    //

    public function postTester(Request $request)
    {
        //$validatedUser = $request->validate([
        //    'macAddress' => 'required',
        //    'phoneNumber' => 'required',
        //]);

        //return response()->json([
         //   "macAddress"=> "online post mac",
         //   "phone_number"=> "online post phone"
        //]);
        return response()->json([
        "status" => "success"
        ]);
    }

    public function getTester(){
        return response()->json([
            "macAddress"=> "online get mac",
            "phone_number"=> "online get phone"
        ]);
    }
    public function get_suspects(Request $request)
    {
      //  $validatedUser = $request->validate([
      //      'latitude' => 'required',
      //      'longitude' => 'required'
      //  ]);

         $sus = new Suspect(
            "mac_address",
            100,
            325.24,
            2345.2345
        );

        $sus2 = new Suspect(
            "mac_address",
            100,
           245.245,3.435
        );
        $suss = array($sus, $sus2);


        return 
        response()->json([
           "suspects"=> json_encode($suss)
        ]);
    }

    
}
class Suspect{
    public $mac_address,$suspection,$latitude,$longitude;
    
    public function __construct($mac_address, $suspection, $latitude, $longitude)
    {
        $this->mac_address = $mac_address;  
        $this->suspection = $suspection;  
        $this->latitude = $latitude;  
        $this->longitude = $longitude;  
    }


    }
