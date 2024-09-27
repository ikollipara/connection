<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // public function index()
    // {
    //     $events = Event::query()->with('user')->get();
    //     return view("events.index", compact("events"));
    // }
    // public function show(Event $event)
    // {
    //     return view('events.show', compact('event'));
    // }

    public function index(Request $request)
    {
        return view('events.index', [
            'mine' => $request->has('attending'),
        ]);
    }

    public function show(Event $event)
    {
        $event->view();

        return view('events.show', [
            'event' => $event,
        ]);
    }

    public static function middleware(): array
    {
        return [];
    }
}
