<?php

namespace App\Http\Controllers;

use App\Swipe;
use App\Elloscore;
use Illuminate\Http\Request;

class SwipeController extends Controller
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
    public function swipeLeft(Request $request)
    {
        $validatedUser = $request->validate([
            'swiper_id' => 'required',
            'swiped_id' => 'required'
        ]);



        $swipe = Swipe::where('swiper_id', '=', $request['swiper_id'])->where('swiped_id', '=', $request['swiped_id'])->first();
        if($swipe!=null) return  response()->json(["status" => "successfull"]);
        
        
        $swipe = new Swipe();
        $swipe->swiper_id = $request['swiper_id'];
        $swipe->swiped_id = $request['swiped_id'];
        $swipe->direction = "Left";
        $swipe->save();

         //update ello score

         $elloscore = ElloScore::where('user_id', '=', $request['swiped_id'])->first();
         if($elloscore != null){
             $elloscore->swipe_count = $elloscore->swipe_count+1;
             $elloscore->final_score = ($elloscore->like_count/$elloscore->swipe_count);
             $elloscore->save();
         }else{
             $elloscore = new ElloScore();
             $elloscore->user_id = $request['swiped_id'];
             $elloscore->swipe_count = 1;
             $elloscore->like_count = 0;
             $elloscore->final_score = 0;
             $elloscore->save();
         }
 
 
 
        return response()->json( [
            "status" => "successfull"
        ]);

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
     * @param  \App\Swipe  $swipe
     * @return \Illuminate\Http\Response
     */
    public function show(Swipe $swipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Swipe  $swipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Swipe $swipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Swipe  $swipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Swipe $swipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Swipe  $swipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Swipe $swipe)
    {
        //
    }
}
