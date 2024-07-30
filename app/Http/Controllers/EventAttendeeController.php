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
        if (!$successful) {
            return session_back()->with("error", __("Failed to attend."));
        }
        return session_back()->with("success", __("You are now attending"));
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
        if (!$successful) {
            return session_back()->with("error", __("Failed to remove."));
        }
        return session_back()->with("success", __("You are no longer attending."));
    }
}
