<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\User;
use App\Http\Resources\User as UserResource;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/me', 'UserController@create')->middleware('auth:api');

Route::post('/unMatch', "MatchController@unMatch");
Route::post('/deleteUser', "UserController@deleteUser");
Route::post('/reportUser', "ReportController@reportUser");


//Home Controller
// find peoples
Route::post('/findpeoples', "FindPeopleController@findPeoples");
Route::post('/reviewPeoples', "UserController@reviewPeoples");
Route::post('/swipe_left', "SwipeController@swipeLeft");

//Like Controller
Route::post('/likers', "LikeController@likers");
Route::post('/newLikers', "LikeController@newLikers");
Route::post('/like', "LikeController@like");
Route::post('/getlike', "LikeController@getLikeForChat");
Route::post('/getlike', "MatchController@getMatchAfter");

//Match Controller
Route::post('/matches', "MatchController@show");
Route::post('/match', "MatchController@create");
Route::post('/getlike', "LikeController@getLikeForChat");

// signUp Users
Route::post('/signup', "UserController@signUp");
Route::get('/getvitalsstruct','UserController@getVgetVitalsStruct');
Route::post('/submitVitals', 'UserController@submitVitals');
Route::post('/getProfile', 'UserController@getProfile');
Route::post('/login', 'UserController@login');
Route::post('/getLoggedInUser', 'UserController@getLoggedInformation');
Route::post('/deletePicture', 'PictureController@deletePicture');





// list Users
Route::get('users', function(){
        return new UserResource(user::findorfail(1));
});





// list single User
Route::get('getuser/{id}', function($id){
    return UserResource(user::findorfail($id));
});




//create new User
Route::post('sign_up', 'UserController@sign_up');

Route::post('postusers', 'UserController@store');

//update User
Route::put('putusers', 'UserController@store');

//Delete user
Route::delete('deleteusers', 'UserController@destroy');




Route::get('/', 'MessageController@index');
Route::get('messages', 'MessageController@fetchMessages');
Route::post('makeMessageSeen', 'MessageController@makeMessageSeen');
Route::post('getAllUnseenMessages', 'MessageController@getAllUnseenMessages');


Route::post('getNewChats', 'UserController@getNewChats');

Route::post('messages', 'MessageController@sendMessage');
Route::post('getchat', 'MessageController@getchat');
Route::post('uploadImage', 'PictureController@create');
Route::post('uploadImageUrl', 'PictureController@store');
Route::post('getImage', 'PictureController@show');
Route::post('setPictureOrder', 'PictureController@setOrder');
Route::post('setAnswerOrder', 'AnswareController@setOrder');

Route::post('getSignedInUser', 'UserController@getSignedInUser');
Route::post('setAnswer', 'UserController@setAnswer');
Route::post('getQuestions', 'UserController@getQuestions');


Route::post('setUserFirebaseRegid', 'FCMTokenController@store');
Route::post('sendNotification', 'SendPushNotificationController@sendNotification');
Route::post('populateMe', 'UserController@populateMe');
Route::post('makeLikeSeen', 'LikeController@makeLikeSeen');






Route::post('editName', 'ProfileController@editName');
Route::post('editSex', 'ProfileController@editSex');
Route::post('editAge', 'ProfileController@editAge');
Route::post('editHeight', 'ProfileController@editHeight');
Route::post('editLocation', 'ProfileController@editLocation');

Route::post('editKids', 'ProfileController@editKids');
Route::post('editFamilyPlan', 'ProfileController@editFamilyPlan');
Route::post('editWork', 'ProfileController@editWork');
Route::post('editJob', 'ProfileController@editJob');
Route::post('editSchool', 'ProfileController@editSchool');
Route::post('editEducation', 'ProfileController@editEducation');
Route::post('editReligion', 'ProfileController@editReligion');
Route::post('editHomeTown', 'ProfileController@editHomeTown');
Route::post('editDrinking', 'ProfileController@editDrinking');
Route::post('editSmoking', 'ProfileController@editSmoking');
Route::post('editRelationshipType', 'ProfileController@editRelationshipType');







Route::post('editSexPreference', 'PreferenceController@editSexPreference');
Route::post('editAgeRangePreference', 'PreferenceController@editAgeRangePreference');
Route::post('editHeightRangePreference', 'PreferenceController@editHeightRangePreference');
Route::post('editReligionPreference', 'PreferenceController@editReligionPreference');
Route::post('editFamilyPlanPreference', 'PreferenceController@editFamilyPlanPreference');
Route::post('editEducationPreference', 'PreferenceController@editEducationPreference');
Route::post('editDrinkPreference', 'PreferenceController@editDrinkPreference');
Route::post('editSmokePreference', 'PreferenceController@editSmokePreference');
Route::post('editMaximumDistancePreference', 'PreferenceController@editMaximumDistancePreference');
Route::post('editkidPreference', 'PreferenceController@editkidPreference');
Route::post('editRelationshipTypePreference', 'PreferenceController@editRelationshipType');




Route::get('getPaymentTypes', 'PaymentController@getPaymentTypes');
Route::post('getPaymentTypesof', 'PaymentController@getPaymentTypesof');
Route::post('getFullPaymentType', 'PaymentController@getFullPaymentType');
Route::post('getFullPaymentTypes', 'PaymentController@getFullPaymentTypes');

Route::post('getUserActivePayments', 'PaymentController@getUserActivePayments');
Route::post('pay', 'PaymentController@pay_by_cbe');
Route::post('pay_by_phone', 'PaymentController@pay_by_phone');





Route::post('getUnmatched', 'MatchController@getUnmatched');
Route::post('matchseen', 'MatchController@matchseen');
Route::post('getNewMatchesAfter', 'MatchController@getNewMatchesAfter');
Route::post('getMatchesAfter', 'MatchController@getMatchesAfter');
Route::post('getMessageAfter', 'MessageController@getMessageAfter');
Route::post('getMessageBefore', 'MessageController@getMessageBefore');
Route::post('reportUser', 'ReportController@reportUser');





Route::post('sessionStart', 'SessionController@sessionStart');
Route::post('sessionEnd', 'SessionController@sessionEnd');

Route::post('boost_me', 'BoostController@boost');

Route::post('deletePhoneNumberLink', 'PhonenumberController@deletePhoneNumber');
Route::post('editPhoneNumberLink', 'PhonenumberController@editPhoneNumber');
Route::post('createPhoneNumberLink', 'PhonenumberController@createPhoneNumber');
Route::post('getLinkedPhoneNumbers', 'PhonenumberController@getLinkedPhoneNumbers');
Route::post('nope', 'NopeController@nope');
