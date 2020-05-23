<?php

namespace App\Http\Controllers;

use App\Report;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
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
   
    public function reportUser(Request $request){
        

        $validatedUser = $request->validate([
            'userid1' => 'required',
            'userid2' => 'required',
        ]);
        $user1 = User::where('id', '=', $request['userid1'])->first();
        $user2 = User::where('id', '=', $request['userid2'])->first();

        $text = $request['text'];
        if($text == null) $text = " ";

        if($user1!=null && $user2!=null){
            $report = new Report();
            $report->reporter_id = $user1->id;
            $report->reported_id = $user2->id;
            $report->text = $text;
            $report->save();
            return response()->json(["status"=>"success"]);
        }else
        return response()->json(["status"=>"failure"]);

        
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
