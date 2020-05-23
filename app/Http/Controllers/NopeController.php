<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nope;
use App\User;
use App\Like;
class NopeController extends Controller
{
    //

    public function Nope(Request $request){
        $validatedRequest = $request->validate([
            'noper_id' => 'required',
            'noped_id' => 'required'
        ]);

        $noper = User::find($request['noper_id']);
        $noped = User::find($request['noped_id']);

        if($noper==null || $noped == null) return response()->json(["status"=>"unsuccessful", "message"=>"Deleted account"]);
        $like = Like::where('liker_user_id', '=', $noped->id)->where('liked_user_id', '=', $noper->id)->first();
        if($like == null) return response()->json(["status"=>"unsuccessful", "message"=>"You have to be liked to say noped."]);
        
        $nopeCheck = Nope::where('noper_id', '=', $noper->id)->where('noped_id', '=', $noped->id)->first();
        if($nopeCheck!=null) return response()->json(["status"=>"unsuccessful", "message"=>"You have already noped the person."]);
        
        $nope = new Nope();
        $nope->noper_id = $noper->id;
        $nope->noped_id = $noped->id;
        $nope->save();
        return response()->json(["status"=>"successful"]);
        
    }











}
