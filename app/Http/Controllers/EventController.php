<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller{
    public function show (Event $event)
    {
        $events = Event::query()->get();
        return view('events.show',compact('events'));
    }
}
