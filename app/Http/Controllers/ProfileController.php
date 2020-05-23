<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use App\Height;
use App\Kid;
use App\Education;
use App\Match;
use App\Religion;
use App\Politic;
use App\Profile;
use App\Preference;
use App\Picture;
use App\Smoke;
use App\Drink;
use App\RelationshipType;
//use App\Language;
use App\Answare;
use App\Location;
use App\FamilyPlan;
use App\Question;
use  App\Http\Resources\FindPeopleResource\LocationFPResource as Loc;
use Illuminate\Http\Request;

class ProfileController extends Controller
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




    ///edit profile page

    public function editName(Request $request){
        $user = User::find($request['user_id']);
        $user->first_name = $request['first_name'];
        $user->save();
        return response()->json([
                "first_name"=>$user->first_name
        ]);
    
    }
    
    
    public function editSex(Request $request){
        $user = User::find($request['user_id']);
    
        $user->sex = ($request['sex'] == 1)? "Man":"Woman";
        
        $user->save();
        return response()->json([
                "sex"=>$user->sex
        ]);
        
    }
    
    
    public function editAge(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->age = $request['age'];
        
        $profile->save();
        return response()->json([
                "age" => $profile->age
        ]);
        
    }
    
    
    public function editHeight(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->height_id = $request['height'];
        
        $profile->save();
        return response()->json([
                "height_id"=>$profile->height_id
        ]);
        
    }
    
    
    public function editLocation(Request $request){
        $location = Location::Where('user_id', '=', $request['user_id'])->first();
        $location->latitude = $request['latitude'];
        $location->longitude = $request['longitude'];
        $location->save();
        return new Loc($location);
        
    }
    
    
    
    
    
    
    
    
    public function editKids(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->kid_id = $request['kid_id'];
        
        $profile->save();
        return response()->json([
                "kid_id"=>$profile->kid_id
        ]);   
    }
    
    public function editFamilyPlan(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->family_plan_id = $request['family_plan_id'];
        
        $profile->save();
        return response()->json([
                "family_plan"=>$profile->family_plan_id
        ]);   
    }
    
    public function editWork(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->work = $request['work'];
        
        $profile->save();
        return response()->json([
                "work"=>$profile->work
        ]);   
    }
    
    public function editJob(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->job = $request['job'];
        
        $profile->save();
        return response()->json([
                "job"=>$profile->job
        ]);   
    }
    
    
    public function editSchool(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->school = $request['school'];
        
        $profile->save();
        return response()->json([
                "school"=>$profile->school
        ]);   
    }
    
    public function editEducation(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->education_id = $request['education_id'];
        
        $profile->save();
        return response()->json([
                "education_id"=>$profile->education_id
        ]);   
    }
    
    public function editReligion(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->religion_id = $request['religion_id'];
        
        $profile->save();
        return response()->json([
                "religion_id"=>$profile->religion_id
        ]);   
    }
    
    public function editHomeTown(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->home_town = $request['home_town'];
        
        $profile->save();
        return response()->json([
                "home_town"=>$profile->home_town
        ]);   
    }
    
    public function editDrinking(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->drink_id = $request['drink_id'];
        
        $profile->save();
        return response()->json([
                "drink_id"=>$profile->drink_id
        ]);   
    }
    
 
    public function editSmoking(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->smoke_id = $request['smoke_id'];
        
        $profile->save();
        return response()->json([
                "smoke_id"=>$profile->smoke_id
        ]);   
    }
    
    public function editRelationshipType(Request $request){
        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
    
        $profile->relationship_type_id = $request['relationship_type_id'];
        
        $profile->save();
        return response()->json([
                "relationship_type_id"=>$profile->relationship_type_id
        ]);   
    }
    
    
    
}
