<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class EventAttendeeController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $event->attendees()->attach($request->user_id);

        return session_back(status: 303)->with('success', __('You are now attending.'));
    }

    public function destroy(Event $event, User $attendee): RedirectResponse
    {
        $event->attendees()->detach($attendee);

        return session_back(status: 303)->with('success', __('You are no longer attending.'));
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
        ];
    }
}
