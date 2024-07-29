<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendeeRequest;
use App\Models\Attendee;

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
        if (! $successful) {
            return back(303)->with('error', __('Failed to attend.'));
        }

        return back(303)->with('success', __('You are now attending'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendee $attendee)
    {
        $successful = $attendee->delete();
        if (! $successful) {
            return back(303)->with('error', __('Failed to remove.'));
        }

        return back(303)->with('success', __('You are no longer attending.'));
    }
}
