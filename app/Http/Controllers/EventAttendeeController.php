<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendeeRequest;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
class EventAttendeeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendeeRequest $request)
    {
        $validated = $request->validated();
        $successful = Attendee::create($validated);
        if(!$successful) {
            return back(303)->with("error", __("Failed to attend."));
        }
        return back(303)->with("success",__("You are now attending"));
        // $event->attendees->attach($validated['user_id']);
        // dd($event);
        // // $user->followers()->attach($validated["user_id"]);
        // return redirect()
        //     ->route('events.show',[$event]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendee  $attendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendee $attendee)
    {
        $successful = $attendee->delete();
        if(!$successful) {
            return back(303)->with("error", __("Failed to remove."));
        }
        return back(303)->with("success",__("You are no longer attending."));
    }
}
