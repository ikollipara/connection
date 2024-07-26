<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller{
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
    // public function show(){
    //     $events = Event::all();
    //     return view('events.show', compact('events'));
    // }
}
