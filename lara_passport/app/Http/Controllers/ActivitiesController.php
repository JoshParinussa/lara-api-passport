<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\ActivitiesUsers;
use App\Models\User;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Activities::with('participants')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'skill_id'=>'required',
            'participants'=>'required',
        ]);

        $activities = new Activities([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'skill_id' => $request->get('skill_id'),
        ]);

            
        $activities->save();
        
        if($activities){
            $participants = explode(",", $request->get('participants'));

            foreach($participants as $participant){
                $activities->participants()->attach(User::find($participant)->id);
            }
        }
        
        return response()->json($activities, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function show($activities)
    {
        $activity = Activities::with('participants')->find($activities);
        if (is_null($activity)) {
            return $this->sendError('Activity not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "Product retrieved successfully.",
            "data" => $activity
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $activities)
    {
        $activity = Activities::find($activities);
        $activity->update($request->except('participants'));
        $participants = explode(",", $request->get('participants'));
        if($request->get('participants')){
            $participants = array_map('intval', explode(",", $request->get('participants')));
            $attachedParticipants = $activity->participants->pluck('id')->toArray();
            $newParticipants = array_diff($participants, $attachedParticipants);
            foreach($newParticipants as $newParticipant){
                $activity->participants()->attach(User::find($newParticipant)->id);
            }
        }

        return response()->json([
            'message'=>'update success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function destroy($activities)
    {
        $activity = Activities::find($activities);
        $activity->participants()->detach();
        $activity->delete();

        return response()->json([
            "message" => "Activity deleted successfully.",
        ], 204);
    }
}
