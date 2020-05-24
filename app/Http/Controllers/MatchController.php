<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatchedPeopleResource\MatchResource;
use App\Http\Resources\MatchedPeopleResource\MatchCollection;
use App\LastKnown;
use App\Match;
use App\UnMatch;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Resources\UnmatchResource;

class MatchController extends Controller
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
    public function create(Request $request)
    {
        $user1 = User::find($request['user_id_1']);
        $user2 = User::find($request['user_id_2']);


        $matched = Match::where('user_id_1', '=', $request['user_id_1'])
                        ->where('user_id_2', '=', $request['user_id_2'])->first();

        // if($matched!=null){
        //     $match = new MatchResource($matched);
        //     return $match->user($user1->id);
        // }


        $matched =  Match::where('user_id_2', '=', $request['user_id_1'])
                         ->where('user_id_1', '=', $request['user_id_2'])->first();
        if($matched!=null) {
            $match = new MatchResource($matched);
            return $match->user($user1->id);
        }

        $match = new Match();
        $match->user_id_1 = $user1->id;
        $match->user_id_2 = $user2->id;
        $match->new = true;
        $match->seen = 0;
        $match->save();

        if($request['comment']!=null){
            $message = new Message();
            $message->sender = $request['user_id_1'];
            $message->reciever = $request['user_id_2'];
            $message->text = $request['comment'];
            $message->save();
            $spn = new SendPushNotificationController($user2);
            $spn->sendMessageNotification();
        }else{
            $spn = new SendPushNotificationController($user2);
            $spn->sendNewMatchNotification($match);
        }

        $matched = new MatchResource($match);
        return $matched->user($user1->id);

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
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){
        $validatedUser = $request->validate([
            'user_id' => 'required',
        ]);
    //     $matches = Match::Where('user_id_1', '=', $request['user_id'])->first();//->paginate(20);
    //    return Match::Chats($request['user_id_1'], $request['user_id_2'])->get();//MatchResource::collection($matches);
    //    $matches = Match::Where('user_id_1', '=', $request['user_id'])->paginate(20);
       $matches = Match::Matches($request['user_id'])->get();



        $lastKnown = LastKnown::where('user_id', '=', $request['user_id'])->first();
        $lastKnown->match_id = ($lastKnown->match_id != null && $lastKnown->match_id>$matches->first()->id)?$lastKnown->match_id:$matches->first()->id;
        $lastKnown->save();



       return MatchCollection::make($matches)->user($request['user_id']);//Response()->json(Match::GetUnseenCount(1, 2));//

    }

    public function getNewMatchesAfter(Request $request){
        $validatedUser = $request->validate([
            'user_id' => 'required'
            ,'match_id' => 'required'
        ]);

        $afterMatchId = $request['match_id'];
        $user = $request['user_id'];

        if($afterMatchId == null){$afterMatchId = 0;}


        $matches = Match::Matches($user)->where('id', '>', $afterMatchId)->where('valid', '=', 1)->get();





        $lastKnown = LastKnown::where('user_id', '=', $request['user_id'])->first();
        $lastKnown->match_id = ($lastKnown->match_id != null && $lastKnown->match_id>$matches->first()->id)?$lastKnown->match_id:$matches->first()->id;
        $lastKnown->save();

        return MatchCollection::make($matches)->user( $user );
    }


    public function getMatchesAfter(Request $request){
        $validatedUser = $request->validate([
            'user' => 'required'
            // , 'message' => 'required'
        ]);
        $user = $request['user'];
        $message = $request['message'];

        if($message == null) $message = 0;

        $matches = Match::GetNewMessagesAfter($user)
        ->where('matches.valid', '=', true)->where('messages.id', '>', $message)->where('matches.new', '=', 0)->get();


        if(sizeof($matches)>0) {
            $lastKnown = LastKnown::where('user_id', '=', $request['user'])->first();
            $lastKnown->match_id = ($lastKnown->match_id != null && $lastKnown->match_id > $matches->first()->id) ? $lastKnown->match_id : $matches->first()->id;
            $lastKnown->save();
        }

        //dd($matches->unique('match_id'));

        return MatchCollection::make($matches->unique('match_id'))->user($user);//Response()->json(Match::GetUnseenCount(1, 2));//

    }



    public static function newCollectionFromStds(Collection $stds, $fill = ['*'], $exists = true)
    {
        $collection = new \Illuminate\Database\Eloquent\Collection;
        foreach ($stds as $std) {
            $instance = new Match();

            $values = ($fill == ['*'])
                ? (array) $std
                : array_intersect_key( (array) $std, array_flip($fill));

            // fill attributes and original arrays
            $instance->setRawAttributes($values, true);

            $instance->exists = $exists;

            $collection->push($instance);
        }
        return $collection;
    }


    public static function newFromStd(stdClass $std, $fill = ['*'], $exists = true)
{
    $instance = new static;

    $values = ($fill == ['*'])
        ? (array) $std
        : array_intersect_key( (array) $std, array_flip($fill));

    // fill attributes and original arrays
    $instance->setRawAttributes($values, true);

    $instance->exists = $exists;

    return $instance;
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function matchSeen(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'match_id' => 'required'
        ]);


        $match = Match::find($request['match_id']);


        if($match == null) return response()->json(["status"=> "no match with this id"]);
        if ($match->user_id_2 != $request["user_id"]) return response()->json(["status"=> "you are not allowed!"]);

         $match->seen = true;
         $match->save();




        return response()->json(["status" =>"success"]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function unMatch(Request $request)
    {
        $validated = $request->validate([
            'user_id_1' => 'required',
            'user_id_2' => 'required'
        ]);

        $user1 = User::find($request['user_id_1']);
        $user2 = User::find($request['user_id_2']);

        $match = Match::getMatch($user1->id, $user2->id)->first();

        if($match==null){return response()->json(["status" =>"failure"]);}

        $match->valid = false;
        $match->save();
        // $messages = Message::GetConversationOf($user1->id, $user2->id);
        // if($messages!=null){
        //        foreach($messages as $m){
        //         $m->delete();
        //     }
        // }



        $unmatch = new Unmatch();
        $unmatch->match_id = $match->id;
        $unmatch->user_id_1 = $match->user_id_1;
        $unmatch->user_id_2 = $match->user_id_2;
        $unmatch->unmatcher_id = $user1->id;
        if($request['text']!=null)
            $unmatch->text = $request['text'];
        $unmatch->save();

        //Message::GetConversationOf($user1->id, $user2->id)->delete();
        //Match::getMatch($user1->id, $user2->id)->delete();


        // $spn = new SendPushNotificationController($user2);
        // $spn->sendUnMatchNotification();
        return response()->json(["status" =>"success"]);

    }

    public function getUnmatched(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required'
        ]);


        $user = User::find($request['user']);

        if($user==null) {return response()->json(["status" =>"failure"]);}


        $unmatch = Unmatch::GetUnmatchesOf($user->id)->get();


        return UnmatchResource::collection($unmatch);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        //
    }
}
