<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventAttendeeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $event->attendees()->attach($request->user_id);

        return session_back(303)->with('success', __('You are now attending.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, User $attendee)
    {
        $event->attendees()->detach($attendee);

        return session_back(303)->with('success', __('You are no longer attending.'));
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
        ];
    }
}
