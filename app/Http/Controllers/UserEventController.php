<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\ValueObjects\Metadata;
use App\Models\Event;

class UserEventController extends Controller
{
    public function index(Request $request, User $user)
    {
        $upcoming = $request->query("upcoming", false);
        $events = Event::query()
            ->with("user")
            ->get();
        return view("users.events.index", compact("events", "upcoming"));
    }

    public function create(User $user)
    {
        // return view('users.events.create');
        // $this->authorize('create', [Event::class, $user]);
        return view("users.events.create", compact("user"));
    }
    public function store(StoreEventRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated["published"] = $validated["published"] == "1";
        $validated["is_all_day"] = isset($validated["is_all_day"]);
        $validated["metadata"] = new Metadata($validated["metadata"]);

        $event = $user->events()->create($validated);

        return redirect()
            ->route("users.events.edit", [$user, $event])
            ->with("success", __("Event successfully created"));
    }
    public function edit(User $user, Event $event)
    {
        return view("users.events.edit", compact("user", "event"));
        // $this->authorize("update", [Event::Class, $user]);
        // return view("users.events.edit", compact("user", "events"));
    }
    public function update(UpdateEventRequest $request, User $user, Event $event)
    {
        $validated = $request->validated();
        $validated["location"] = $validated["location"] ?? "";
        if (isset($validated["archive"])) {
            $should_archive = $validated["archive"] == "1";
            $event->{$should_archive ? "delete" : "restore"}();
            return back(303)->with("success", __("Event successfully " . ($should_archive ? "archived" : "restored")));
        }
        $validated["published"] = $validated["published"] == "1";
        $validated["metadata"] = new Metadata($validated["metadata"]);
        return back(303)->with("success", __("Event successfully updated"));
    }
    public function destroy(User $user, Event $event)
    {
        $successful = $event->delete();
        if ($successful) {
            return redirect()
                ->route("users.events.index", [$user, $event])
                ->with("success", __("Event successfully cancelled"));
        }
    }
}
