<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Resources\FindPeopleResource\LikeResource;
use App\RelationshipType;
use App\Like;
use App\User;
use App\Height;
use App\Kid;
use App\Swipe;
use App\Education;
use App\Payment;
use App\Match;
use App\Religion;
use App\Politic;
use App\Profile;
use App\Report;
use App\Preference;
use App\Picture;
use App\Smoke;
use App\Drink;
use App\Message;
use App\FCMToken;
//use App\Language;
use App\Answare;
use App\Location;
use App\FamilyPlan;
use App\PaymentType;
use App\Question;
use App\Http\Resources\Height as HeightResource;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Http\Resources\FindPeopleResource\Q_and_AFPResource as QandAFPResource;
use App\Http\Resources\FindPeopleResource\PictureFPResource as PictureFPResource;
use App\Http\Resources\FindPeopleResource\ProfileFPResource as ProfileFPResource;
use App\Http\Resources\FindPeopleResource\UserFPResource as UserFPResource;
use App\Http\Resources\FindPeopleResource\LocationFPResource as LocationFPResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\Question as QuestionResource;


use App\Http\Resources\Education as EducationResource;
use App\Http\Resources\Religion as ReligionResource;
use App\Http\Resources\Politic as PoliticResource;
use App\Http\Resources\Smoke as SmokeResource;
use App\Http\Resources\Drink as DrinkResource;
use App\Http\Resources\Language as LanguageResource;
use App\Http\Resources\Kid as KidResource;
use App\Http\Resources\FamilyPlan as FamilyPlanResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\SignedInUserResource\ProfileResource as SignedUserResource;
use App\Http\Resources\PaymentResource\PaymentType as PaymentTypeResource;

class FindPeopleController extends Controller
{
  

     public $location, $max_distance;

    public function findPeoples(Request $request){
        
        $validatedUser = $request->validate([
            
            'user_id' => 'required',
            
         ]);

     
        //load preference
        $preference  = Preference::where('user_id', '=', $request['user_id'])->first();
            

        //load all users;
        $profiles = Profile::where('profiles.user_id', '!=', $request['user_id']);
        
        
        //filter by sex
        if($preference->sex == "Man" || $preference->sex == "Woman"){
            $profiles = $profiles->where('sex', '=', $preference->sex);
        }
        

        // //filter by min age
        // if($preference->min_age >= 18 && $preference->min_age !=null ){
        //     $profiles = $profiles->where('age', '>=', $preference->min_age);
        // }
       
        
        // //filter by max age
        // if($preference->max_age >= 18 && $preference->max_age !=null ){
        //     $profiles = $profiles->where('age', '<=', $preference->max_age);
        // }


        // //filter by min height
        // if($preference->min_height_id > 0  && $preference->min_height_id !=null){
        //     $profiles = $profiles->where('height_id', '>=', $preference->min_height_id);
        // }


        // //filter by max height
        // if($preference->max_height_id > 0 && $preference->max_height_id !=null){
        //     $profiles = $profiles->where('height_id', '<=', $preference->max_height_id);
        // }

        
        
        // //filter by smoke
        // $smoke_id = Smoke::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->smoke_id != $smoke_id && $preference->smoke_id!=null){
        //     $profiles = $profiles->where('smoke_id', '=', $preference->smoke_id);
        // }


        // //filter by drink
        // $drink_id = Drink::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->drink_id != $drink_id && $preference->drink_id!=null){
        //      $profiles = $profiles->where('drink_id', '=', $preference->drink_id);
        //  }
 
        // //filter by family_plan
        // $family_plan_id = FamilyPlan::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->family_plan_id != $family_plan_id && $preference->family_plan_id!=null){
        //      $profiles = $profiles->where('family_plan_id', '=', $preference->family_plan_id);
        //  }
 
 
        //  //filter by education_id
        // $education_id = Education::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->education_id != $education_id && $preference->education_id!=null){
        //      $profiles = $profiles->where('education_id', '=', $preference->education_id);
        //  }
 

        //  //filter by religion_id
        // $religion_id = Religion::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->religion_id != $religion_id && $preference->religion_id!=null){
        //      $profiles = $profiles->where('religion_id', '=', $preference->religion_id);
        //  }
 
        //   //filter by kid_id
        // $kid_id = Kid::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->kid_id != $kid_id && $preference->kid_id!=null){
        //       $profiles = $profiles->where('kid_id', '=', $preference->kid_id);
        //   }
        
        
        // //filter by relationship type
        // $relationship_type_id = RelationshipType::where('id', '>', 0)->orderBy('id', 'desc')->first()->id;
        // if($preference->relationship_type_id != $relationship_type_id && $preference->relationship_type_id!=null){
        //         $profiles = $profiles->where('relationship_type_id', '=', $preference->relationship_type_id);
        // }



        // //filter which is not matched before
        // $profiles = $profiles->PeoplesNotMatchedWithYou($preference->user_id);


        //filter that you didn't noped
        $profiles = $profiles->PeoplesYouDidntNoped($preference->user_id);


        // // filter by location
        // $profiles = $profiles->PeoplesInDistance($preference->location, $preference->max_distance);

        // //calculate elloscore last_time_logged_in
        // $profiles->calculateDesirability($preference->elloScore->final_score);







        //fetch boost and make it preceed
        $boostedProfiles = $profiles->BoostedProfiles()->get();
        $unBoostedProfiles = $profiles->unBoostedProfiles()->get();
        $profiles = $boostedProfiles->merge($unBoostedProfiles);

        $profileTest = ProfileFPResource::collection(
            $this->paginate($profiles)
        );

        return $profileTest;
    }


    public function paginate($items, $perPage = 20, $page = null, $options = [])
{
	$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

	$items = $items instanceof Collection ? $items : Collection::make($items);

	return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}





}