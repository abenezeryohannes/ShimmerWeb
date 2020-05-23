<?php

namespace App\Http\Controllers;

use App\Preference;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function show(Preference $preference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function edit(Preference $preference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preference $preference)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preference $preference)
    {
        //
    }




    // $table->unsignedBigInteger('user_id');
    // $table->unsignedBigInteger('max_height_id')->nullabe();
    // $table->unsignedBigInteger('min_height_id')->nullabe();
    
    // $table->unsignedBigInteger('smoke_id')->nullable();
    // $table->unsignedBigInteger('drink_id')->nullable();
    // $table->unsignedBigInteger('kid_id')->nullable();
    // $table->unsignedBigInteger('education_id')->nullable();


    

        
    public function editSexPreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->sex = ($request['sex_preference'] == 1)? "Man":"Woman";
        
        $preference->save();
        return response()->json([
                "sex_preference" => $preference->sex
        ]);   
    }


       
    public function editAgeRangePreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->min_age = $request['min_age'];
        $preference->max_age = $request['max_age'];
        
        $preference->save();
        return response()->json([
                "min_age"=>$preference->min_age,
                "max_age"=>$preference->max_age
        ]);   
    }

    

       
    public function editHeightRangePreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->min_height_id = $request['min_height_id'];
        $preference->max_height_id = $request['max_height_id'];
        
        $preference->save();
        return response()->json([
                "min_height_id"=>$preference->min_height_id,
                "max_height_id"=>$preference->max_height_id
        ]);   
    }


    
       
    public function editReligionPreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->religion_id = $request['religion_id'];
        
        $preference->save();
        return response()->json([
                "religion_id"=>$preference->religion_id
        ]);   
    }


    
    public function editFamilyPlanPreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->family_plan_id = $request['family_plan_id'];
        
        $preference->save();
        return response()->json([
                "family_plan_id"=>$preference->family_plan_id
        ]);   
    }


    
    public function editkidPreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->kid_id = $request['kid_id'];
        
        $preference->save();
        return response()->json([
                "kid_id"=>$preference->kid_id
        ]);   
    }



    
    public function editEducationPreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->education_id = $request['education_id'];
        
        $preference->save();
        return response()->json([
                "education_id"=>$preference->family_plan_id
        ]);   
    }

    
    
    public function editDrinkPreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->drink_id = $request['drink_id'];
        
        $preference->save();
        return response()->json([
                "drink_id"=>$preference->drink_id
        ]);   
    }

    
    
    public function editSmokePreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->smoke_id = $request['smoke_id'];
        
        $preference->save();
        return response()->json([
                "smoke_id"=>$preference->smoke_id
        ]);   
    }



    
        
    public function editMaximumDistancePreference(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->max_distance = $request['max_distance'];
        
        $preference->save();
        return response()->json([
                "max_distance"=>$preference->max_distance
        ]);   
    }


    
        
    public function editRelationshipType(Request $request){
        $preference = Preference::Where('user_id', '=', $request['user_id'])->first();

        $preference->relationship_type_id = $request['relationship_type_id'];
        
        $preference->save();
        return response()->json([
                "relationship_type_id"=>$preference->relationship_type_id
        ]);   
    }



}
