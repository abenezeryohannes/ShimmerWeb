<?php

namespace App\Http\Controllers;

use App\Http\Resources\FindPeopleResource\LikeResource;
use App\Like;
use App\Nope;
use App\User;
use App\Unmatch;
use App\Session;
use App\LastTimeLoggedin;
use App\Boost;
use App\Height;
use App\ElloScore;
use App\Kid;
use App\Swipe;
use App\LastKnown;
use App\Education;
use App\Payment;
use App\Match;
use App\Religion;
use App\Politic;
use App\Profile;
use App\Report;
use App\Setting;
use App\Preference;
use App\RelationshipType;
use App\Picture;
use App\Smoke;
use App\Drink;
use App\Message;
use App\FCMToken;
//use App\Language;
use App\Answare;
use App\Location;
use App\FamilyPlan;
use App\Phonenumber;
use App\PaymentType;
use App\Question;
use App\Http\Resources\Height as HeightResource;

use App\Http\Resources\FindPeopleResource\Q_and_AFPResource as QandAFPResource;
use App\Http\Resources\FindPeopleResource\PictureFPResource as PictureFPResource;
use App\Http\Resources\FindPeopleResource\ProfileFPResource as ProfileFPResource;
use App\Http\Resources\FindPeopleResource\RelationshipTypeResources as RelationshipTypeResources;
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
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::all();
        return $result;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $validatedUser = $request->validate([
            // 'phone_number' => 'required'
            ]);

        // $request->facebook_id;
        if($request->phone_number != null){
           $user = User::where('phone_number', '=', $request->phone_number)->first();
           if($user == null){
               $user = new User();
               $user->phone_number = $request->phone_number;
           }

        }else if ($request->facebook_id != null ){
            $user = User::where('facebook_id', '=', $request->facebook_id)->first();
            if($user == null){
                $user = new User();
                $user->facebook_id = $request->facebook_id;
            }
        }else{
            return response()->json(["status"=>"failure", "message"=>"no phone number or facebook info provided !! "]);
        }

        // $user->first_name = $request->first_name;
        // $user->last_name = $request->last_name;
        $user->save();

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->save();


        $preference = new Preference();
        $preference->user_id = $user->id;
        $preference->save();


        return response()->json([
                "user_id" => $user->id,
                "profile_id" => $profile->id,
                "preference_id" => $preference->id
        ]);

        return new UserResource($user);

    }



    public function getNewChats(Request $request){

        $validatedUser = $request->validate([
            "user_id" => "required"
        ]);


        //get all unread messages

        //group all unread messages by

        //get all unread message matches







    }








    public function login(Request $request){

        $validatedUser = $request->validate([
            // 'phone_number' => 'required'
            ]);

             // $request->facebook_id;
        if($request->phone_number != null){
            $phone_number = $request['phone_number'];
            // dd("phone!=null");
            $phone_number = str_replace(' ', '', $phone_number);
            $user = User::where('phone_number', '=', $request->phone_number)->first();
            // if($user == null){
            //     $user = new User();
            //     $user->phone_number = $request->phone_number;
            //     // $user->save();
            // }

         }else if ($request->facebook_id != null ){
             $user = User::where('facebook_id', '=', $request->facebook_id)->first();
        //    dd("phone==null but fb is not " . $user);

            //  if($user == null){
            //      $user = new User();
            //      $user->facebook_id = $request->facebook_id;
            //     //  $user->save();
            //  }
         }else{
             return response()->json(["status"=>"failure", "message"=>"no phone number or facebook info provided !! "]);
         }


        if($user != null){
            $profile = (Profile::where('user_id', '=', $user->id)->first());
           // dd($user->id);

            if($user->pictures()->first() != null)
                return response()->json(["status" => "old", "user_profile" => new SignedUserResource(Profile::find($profile->id))]);
            else
                return response()->json(["status" => "new", "user_profile" => new SignedUserResource(Profile::find($profile->id))]);
        }else
            $user = new User;
            if($request->phone_number != null){
                $phone_number = $request->phone_number;
                $phone_number = str_replace(' ', '', $phone_number);
                $user->phone_number = $request->phone_number;
             }else if ($request->facebook_id != null ){
                     $user->facebook_id = $request->facebook_id;
                 }

            //  $user->phone_number = $phone_number;
            // $user->first_name = $request->first_name;
            // $user->last_name = $request->last_name;
            $user->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();


            $preference = new Preference();
            $preference->user_id = $user->id;
            $preference->max_height_id = 60;
            $preference->min_height_id = 1;
            $preference->min_age = 18;
            $preference->max_age = 100;
            $preference->sex = "Men";
            $preference->relationship_type_id = 1;
            $preference->save();

            $profile = new ProfileFPResource(Profile::where('user_id', '=', $user->id)->first());

            return response()->json(
                [
                    "status" => "new",
                    "user_profile" => new SignedUserResource(Profile::find($profile->id))

                ]);

    }










    public function reviewPeoples(Request $request){

        $validatedUser = $request->validate([

            'user_id' => 'required',

            ]);

        Swipe::where('swiper_id', '=', $request['user_id'])->delete();

        return response()->json([
                "status"=>"success"
        ]);
    }







    public function getProfile(Request $request){

        $validatedUser = $request->validate([

            'user_id' => 'required',
            ]);

        $profile = Profile::Where('user_id', '=', $request['user_id'])->first();
        if($profile == null) return  response()->json([
            "profile" => "null",
        ]);

        return new ProfileResource($profile);
    }












    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signUp(Request $request){

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sign_up(Request $request){


        $validatedUser = $request->validate([
            // 'phone_number' => 'required',
            // 'facebook_id' => 'required',
            'first_name' => 'required',
            'age' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            // 'relationship_type_id' => 'required',
            // 'school' => 'required',
            'sex' => 'required',
            'sex_preference' => 'required',
            'height_id' => 'required',
            'kid_id' => 'required',
            'family_plan_id' => 'required',
            // 'education_id' => 'required',
            // 'work' => 'required',
            // 'job' => 'required',
            // 'religion_id' => 'required',
            // 'home_town' => 'required',
            'smoke_id' => 'required',
            'drink_id' => 'required',
        ]);

        $phone_number = $request['phone_number'];
        $facebook_id = $request['facebook_id'];
        if($phone_number!=null){
            $phone_number = str_replace(' ', '', $phone_number);
            $phone_number = str_replace('+251', '', $phone_number);
            $phone_number = str_replace('00251', '', $phone_number);

            $deletePhoneRelation = Phonenumber::where('phone_number', '=', $request['phone_number'])->delete();

        // return response()->json([
        //     "sex" => "sex"]);

            $user = User::where('phone_number', '=', $phone_number)->first();
            if($user == null){
                $user = new User();
            }
            $user->phone_number = $phone_number;


        }else if($facebook_id!=null){
            $user = User::where('facebook_id', '=', $facebook_id)->first();
            if($user == null){
                $user = new User();
            }
            $user->facebook_id = $facebook_id;

        }else return response()->json(["status"=>"failure", "message"=>"No phone number or facebook id submited"]);




        $user->first_name = $validatedUser['first_name'];
        // $user->sex = ($validatedUser['sex'] == 1)? "Man":"Woman";
        $user->save();

        //dd($user);
        $location = new Location();
        $location->user_id =$user->id;
        $location->latitude = $validatedUser['latitude'];
        $location->longitude = $validatedUser['longitude'];
        $location->save();

        //dd($location);
        $profile = Profile::where('user_id', '=', $user->id)->first();
        if($profile == null){
            $profile = new Profile();
        }
        $profile->user_id = $user->id;
        $profile->kid_id = $validatedUser['kid_id'];
        $profile->education_id = $request['education_id'];
        $profile->relationship_type_id = $request['relationship_type_id'];
        $profile->religion_id = $request['religion_id'];
        $profile->sex = ($validatedUser['sex'] == 1)? "Man":"Woman";
        $profile->age = $validatedUser['age'];
        $profile->height_id = $validatedUser['height_id'];
        $profile->work = $request['work'];
        $profile->job = $request['job'];
        $profile->school = $request['school'];
        $profile->drink_id = $validatedUser['drink_id'];
        $profile->smoke_id = $validatedUser['smoke_id'];
        $profile->home_town = $request['home_town'];
        $profile->family_plan_id = $validatedUser['family_plan_id'];
        $profile->completed = (40 + (($user->answers->count() + $user->pictures->count())*5));
        $profile->save();
        //dd($profile);
        $Preference = Preference::where('user_id', '=', $user->id)->first();
        if($Preference == null)
            $Preference = new Preference();
        $Preference->user_id = $user->id;
        $Preference->family_plan_id = $request['family_plan_id'];
        if($validatedUser['sex_preference'] == 3){
            $Preference->sex = "Man or Woman";
        } else
        $Preference->sex = ($validatedUser['sex_preference'] == 1)? "Man":"Woman";
//        $Preference->relationship_type_id = $request['relationship_type_id'];

        $Preference->min_height_id = Height::all()->orderBy('id', 'asc')->first()->id;
        $Preference->max_height_id = Height::all()->orderBy('id', 'desc')->first()->id;
        $Preference->min_age = 18;
        $Preference->max_age = 100;
        //dd($preference);
        $Preference->save();

        $profile->completed = (55 + (($user->answers->count() + $user->pictures->count())*5));




         //save ello score
             $elloscore = new ElloScore();
             $elloscore->user_id = $user->id;
             $elloscore->swipe_count = 0;
             $elloscore->like_count = 0;
             $elloscore->final_score = 1.0;
             $elloscore->save();


            if($phone_number!=null){
            //save phone link
            $phone_link = new Phonenumber();
            $phone_link->phone_number = $phone_number;
            $phone_link->user_id = $user->id;
            $phone_link->save();
            }

        // //3 new likes
        // $allUsers = User::all();


        // foreach($allUsers as $u){
        //     if($u->id==$user->id)continue;
        //     $match = new Match();
        //     $match->user_id_1 = $u->id;
        //     $match->user_id_2 = $user->id;
        //     $match->seen = 0;
        //     $match->save();
        // }

        $lastKnown = new LastKnown();
        $lastKnown->user_id = $user->id;
        $lastKnown->save();

        //Free membership for first time registration

        $payment_type = PaymentType::where('type', '=', 'subscribtion')->first();
        if($payment_type!=null) {
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->payment_type_id = $payment_type->id;
            $today = Carbon::now();
            $payment->expiration_date = $today->addDays($payment_type->date_length);
            $payment->save();
        }


        return new SignedUserResource(Profile::find($profile->id));
        // return new ProfileFPResource(Profile::Where('id', '=', $profile->id)->first());
    }


    public function populateMe(Request $request){
          //3 new likes

          $user = User::find($request['user_id']);
          $allUsers = User::all();

          foreach($allUsers as $u){
              if($u->id==$user->id)continue;
              $like = new Like();
              $like->liker_user_id = $u->id;
              $like->liked_user_id = $user->id;

              $picture = Picture::where('user_id', '=', $user->id)->first();
              $like->picture_id = $picture->id;

              $like->notified = false;
              $like->comment = "U luk cute!";
              $like->save();
          }

          foreach($allUsers as $u){
              if($u->id==$user->id)continue;
              $match = new Match();
              $match->user_id_1 = $u->id;
              $match->user_id_2 = $user->id;
              $match->seen = 0;
              $match->save();
          }


          return response()->json(["status"=>"success"]);
          //3 new matches
    }




    public function getComplitionPercentageOfUser(User $user){
        $answers = $user->answers->count();
        $pictures = $user->pictures->count();
        $count = (40 + (($answers + $pictures)*5));

        return response()->json([
            "answers"=> $answers,
            "pictures"=> $pictures,
            "count" => $count
        ]);

        return $count;


    }





    /**
     *
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
     * @param  \App\Answare  $answare
     * @return \Illuminate\Http\Response
     */
    public function show(Answare $answare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answare  $answare
     * @return \Illuminate\Http\Response
     */
    public function edit(Answare $answare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answare  $answare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answare $answare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answare  $answare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answare $answare)
    {
        //
    }




    public function getVgetVitalsStruct(){


        $payment_type = PaymentTypeResource::collection(PaymentType::all());
        $heights = HeightResource::collection(Height::all());
        $kids = KidResource::collection(Kid::all());
        $education = EducationResource::collection(Education::all());
        //$language = LanguageResource::collection(Language::all());
        $Politic = PoliticResource::collection(Politic::all());
        $religion = ReligionResource::collection(Religion::all());
        $smoke = SmokeResource::collection(Smoke::all());
        $drink = DrinkResource::collection(Drink::all());
        $familyPlan = FamilyPlanResource::collection(FamilyPlan::all());
        $relationshipTypes = RelationshipTypeResources::collection(RelationshipType::all());
        $setting = Setting::all()->first();
        $relationshipTypes = RelationshipTypeResources::collection(RelationshipType::all());
        $sex = ["Men", "Women"];
        $sexPref = ["Men", "Women", "both"];

        return response()->json([
                "sex" => $sex,
                "sex_preference" => $sexPref,
                "relationship_types" => $relationshipTypes,
                "height" => $heights,
                "kid" => $kids,
                "family_plan" => $familyPlan,
                "education" => $education,
                "religion" => $religion,
                "smoke" => $smoke,
                "drink" => $drink,
                "payment_types" => $payment_type,
                "phone_number" => $setting->phone_number,
                "bank_account"=> $setting->bank_account,
                "free_tg_invitation"=> $setting->free_tg_invitation
                ]);

    }



    public function submitVitals(Request $request){
        $validateUser =  $request;

        $profile = new Profile();
        $location = new Location();
        $Preference = new Preference();
        $location->user_id = $request['user_id'];
        $location->latitude = $validateUser['latitude'];
        $location->longitude = $validateUser['longitude'];
       // $location->save();


        $profile->user_id = $validateUser['user_id'];
        $profile->kid_id = $validateUser['kid'];
        $profile->education_id = $validateUser['education'];
        $profile->relationship_type_id = $validateUser['relationship_type_id'];
        $profile->religion_id = $validateUser['religion'];
        $profile->politic_id = $validateUser['politic'];
        $profile->sex = $validateUser['sex'];
        $profile->age = $validateUser['age'];
        $profile->height_id = $validateUser['height'];
        $profile->work = $validateUser['work'];
        $profile->job = $validateUser['job'];
        $profile->school = $validateUser['school'];
        $profile->drink_id = $validateUser['drink'];
        $profile->smoke_id = $validateUser['smoke'];

        $Preference->user_id = $validateUser['user_id'];
        $Preference->kid_id = $validateUser['family_plan'];
        $Preference->sex = $validateUser['sex_preference'];


        return response()->json([
            "location" => $location,
            "profile" => $profile,
            "preference" => $Preference
        ]);



    }



    public function getQuestions(Request $request){

        $questions = Question::all();

        return QuestionResource::collection($questions);


    }


    public function setAnswer(Request $request){

        $answer = Answare::where('user_id', '=', $request['user_id'])
                        ->Where('order', '=', $request['order'])->first();


        if($answer == null )
            $answer = new Answare();

        $answer->question_id = $request["question_id"];
        $answer->text = $request["answer"];
        $answer->user_id = $request["user_id"];
        $answer->order = $request["order"];
        $answer->save();


        $profile = Profile::where('user_id', '=', $answer->user_id)->first();
        $profile->completed = (55 + (($profile->answers->count() + $profile->pictures->count())*5));
        $profile->save();


        return new QandAFPResource($answer);


    }

    public function getSignedInUser(Request $request){

        $user = User::find($request["user_id"]);
        $profile = Profile::Where('user_id', '=', $user->id )->first();

        return new SignedUserResource($profile);


    }


    public function deleteUser(Request $request){


        $validatedUser = $request->validate([
            'user_id' => 'required',
        ]);

        $user = User::find($request['user_id']);

        if($user == null) return  response()->json(["status" => "success"]);
         // return $message;
         $like = Like::where('liker_user_id', '=', $user->id)->orWhere('liked_user_id', '=', $user->id)->delete();
        //like
        // return $like;
        $match = Match::where('user_id_1', '=', $user->id)->orWhere('user_id_2', '=', $user->id)->delete();
        $message = Message::GetConversation($user->id)->delete();


        //FCMToken
        $fcmtoken = FCMToken::where('user_id', '=', $user->id)->delete();


         //profile
        $profile = Profile::where('user_id', '=', $user->id)->delete();
        //preference
        $preference = Preference::where('user_id', '=', $user->id)->delete();
        //location
        $location = Location::where('user_id', '=', $user->id)->delete();
        // return $location;

        //report
        $report = Report::where('reporter_id', '=', $user->id)->orWhere('reported_id', '=', $user->id)->delete();
        // return $report;

        //answer
        $answer = Answare::where('user_id', '=', $user->id)->delete();
        // return $answer;
        //payment
        //$payment = Payment::where('user_id', '=', $user->id)->get();
        //return $payment;
        //picture
        $picture = Picture::where('user_id', '=', $user->id)->delete();
        // return $picture;
        //swiped left
        $swipe = Swipe::where('swiped_id', '=', $user->id)->orWhere('swiper_id', '=', $user->id)->delete();
        // return $swipe;
        //match
        $elloscore = ElloScore::where('user_id', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $lastKnown = LastKnown::where('user_id', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $lastKnown = Nope::where('noped_id', '=', $user->id)->orWhere('noper_id', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $lastKnown = PhoneNumber::where('user_id', '=', $user->id)->delete();
        // return $elloscore;
        //match
        $lastKnown = Unmatch::where('user_id_1', '=', $user->id)->orWhere('user_id_2', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $lastKnown = Boost::where('user_id', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $session = Session::where('user_id', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $lastTimelogedin = LastTimeLoggedin::where('user_id', '=', $user->id)->delete();
        // return $elloscore;
        //match

        $user->delete();
        return response()->json(["status" => "success"]);
        //

    }



    public function getLoggedInformation(Request $request){

        $user_id = $request['user_id'];

        $user =  User::find($user_id);

        if($user != null){
            $profile = new ProfileFPResource(Profile::where('user_id', '=',$user_id)->first());
                return  new SignedUserResource(Profile::find($profile->id));
        }
        else return response()->json(["No user with this id!"]);
    }
























}
