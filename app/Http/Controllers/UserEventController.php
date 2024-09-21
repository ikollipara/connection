<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use App\ValueObjects\Metadata;
use App\ValueObjects\Editor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserEventController extends Controller
{
    public function index(Request $request, User $user)
    {
        $events = $user->events()->get();
        return view("users.events.index", compact("events", "user"));
    }

    public function create(User $user)
    {
        // return view('users.events.create');
        // $this->authorize('create', [Event::class, $user]);
        return view('users.events.create', compact('user'));
    }

    public function store(StoreEventRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated["is_all_day"] = isset($validated["is_all_day"]);
        $validated["metadata"] = new Metadata($validated["metadata"]);
        $validated["location"] = $validated["location"] ?? "";
        $validated["start_time"] =  data_get($validated, "start_time");
        $validated["end_time"] =  data_get($validated, "end_time");
        $validated["start"] = Event::combineDateAndTime($validated["start_date"], $validated["start_time"]);
        $validated["end"] = is_null($validated['end_date']) ? null : Event::combineDateAndTime($validated["end_date"], $validated["end_time"]);
        $validated["description"] = Editor::fromJson($validated["description"]);
        unset($validated["start_date"], $validated["end_date"], $validated["start_time"], $validated["end_time"]);

        $event = $user->events()->create($validated);

        return redirect(route('users.events.edit', [$user, $event]))->with("success", __("Event successfully created"));
    }

    public function edit(User $user, Event $event)
    {
        return view('users.events.edit', compact('user', 'event'));
        // $this->authorize("update", [Event::Class, $user]);
        // return view("users.events.edit", compact("user", "events"));
    }

    public function update(UpdateEventRequest $request, User $user, Event $event)
    {
        $validated = $request->validated();
        $validated["metadata"] = new Metadata($validated["metadata"]);
        $validated["location"] = $validated["location"] ?? "";
        $validated["is_all_day"] = isset($validated["is_all_day"]);
        $validated["start_time"] =  data_get($validated, "start_time");
        $validated["end_time"] =  data_get($validated, "end_time");
        $validated["start"] = Event::combineDateAndTime($validated["start_date"], $validated["start_time"]);
        $validated["end"] = is_null($validated['end_date']) ? null : Event::combineDateAndTime($validated["end_date"], $validated["end_time"]);
        $validated["description"] = Editor::fromJson($validated["description"]);
        unset($validated["start_date"], $validated["end_date"], $validated["start_time"], $validated["end_time"]);

        $event->update($validated);
        return session_back()->with("success", __("Event successfully updated"));
    }

    public function destroy(User $user, Event $event)
    {
        $successful = $event->delete();
        if ($successful) {
            return redirect()
                ->route('users.events.index', [$user, $event])
                ->with('success', __('Event successfully cancelled'));
        }
    }
}
