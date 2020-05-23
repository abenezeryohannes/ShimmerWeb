<?php

namespace App\Http\Controllers;

use App\Answare;
use App\Http\Resources\FindPeopleResource\Q_and_AFPResource as QandAFPResource;
use Illuminate\Http\Request;

class AnswareController extends Controller
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


    
    public function setOrder(Request $request){


        $answer = Answare::where('user_id', '=', $request['user_id'])
                            ->where('id', '=', $request['answer_id'])->first();
        
        if($answer == null)
        {
            new QandAFPResource(null);
        }

        $answer->order =  $request['order'];
        $answer->save();

        return new QandAFPResource($answer);
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
}
