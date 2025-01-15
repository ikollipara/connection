<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class EventAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        return response()
            ->json($event->attendees()->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $event->attendees()->updateOrCreate(
            ['user_id' => $request->user_id],
        );

        return response(status: 201)->json([
            'message' => 'You are now attending',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, $user)
    {
        $event->attendees()->detach([$user]);

        return response()->json([
            'message' => 'You are no longer attending',
        ]);
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('verified', only: ['store', 'destroy']),
        ];
    }
}
