<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\LastKnown;
use App\Message;
use App\User;
use App\Match;
use Illuminate\Http\Request;
use App\Http\Resources\ChatResource\Chat as ChatRes;

class MessageController extends Controller
{


    public function __construct()
    {
        //    $this->middleware('auth');
    }



    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {

        $user = User::where('id', '=',$request['receiver'])->first();
        // return $user->UnreadCount($user->id);


        $match_id = $request['match'];
        $matched = Match::find($match_id);


        if($matched == null)
        $matched =
        Match::where('user_id_1', '=', $request['sender'])
        ->where('user_id_2', '=', $request['receiver'])
        ->orWhere('user_id_2', '=', $request['sender'])
        ->where('user_id_1', '=', $request['receiver'])
        ->first();


        if($matched == null ) return response()->json(['status'=> 'you are not matched yet!']);

        if($matched->user_id_2 == $request['sender'])
            {
                $matched->seen = true;
            }


        $matched->new = false;
        $matched->save();

        $message = new Message();
        $message->match_id = $matched->id;
        $message->message = $request['message'];
        $message->sender_id = $request['sender'];
        $message->reciever_id = $request['receiver'];
        $message->seen = 0;


        $message->save();



         $spn = new SendPushNotificationController($user);
         $spn->sendMessageNotification();

        return new ChatRes($message);
    }



    public function getchat(Request $request){
        $validatedUser = $request->validate([
            'user_id_1' => 'required',
            'user_id_2' => 'required',
        ]);

        $messages = Message::GetConversationOf($request['user_id_1'], $request['user_id_2'])->paginate(20);
        if(sizeof($messages)>0) {
            $lastKnown = LastKnown::where('user_id', '=', $request['user_id'])->first();
            $lastKnown->message_id = ($lastKnown->message_id > $messages[0]->id) ? $lastKnown->message_id : $messages[0]->id;
            $lastKnown->save();
        }
        return ChatRes::collection($messages);
    }



    public function getMessageAfter(Request $request){

        $messages = Message::GetConversationOf($request['user_id_1'], $request['user_id_2'])->paginate(20);

        if(sizeof($messages)>0) {
            $lastKnown = LastKnown::where('user_id', '=', $request['user_id_1'])->first();
            $lastKnown->message_id = ($lastKnown->message_id != null && $lastKnown->message_id > $messages[0]->id) ? $lastKnown->message_id : $messages[0]->id;
            $lastKnown->save();
        }
        return ChatRes::collection($messages);
    }


    public function getMessageBefore(Request $request){
        return ChatRes::collection(Message::GetConversationOf($request['user1'], $request['user2'])->where('messages.id', '<', $request['message'])->paginate(20));
    }




    public function getlastChat(Request $request){

        $validatedUser = $request->validate([
            'user_id_1' => 'required',
            'user_id_2' => 'required',
        ]);

        return new ChatRes(Message::GetConversationOf($request['user_id_1'], $request['user_id_2'])->latest());

    }


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
    public function makeMessageSeen(Request $request)
    {

        $validatedRequest = $request->validate([
            'user_id' => 'required',
            'message_id' => 'required',
        ]);


        $message = Message::find($request['message_id']);

        if($message->reciever_id == $request['user_id']){
            $message->seen = true;
            $message->save();
            return response()->json(["status"=> "Success"]);
        }

        return response()->json(["status"=> "Error, You are Not reciever or message id doesn't exist."]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function getAllUnseenMessages(Request $request, Message $message)
    {

        $startingFrom = $request['message_id'];

        if($startingFrom == null){

        }else{


        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
