<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use App\ValueObjects\Editor;
use App\ValueObjects\Metadata;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

final class UserEventController extends Controller
{
    public function index(Request $request, User $user)
    {
        $q = $request->query('q', '');
        $events = $user->events()->search($q)->withCount(['days', 'attendees'])->paginate(15);

        return view('users.events.index', [
            'events' => $events,
        ]);
    }

    public function create(Request $request, User $user)
    {
        return view('users.events.create', [
            'user' => $user,
            'event' => new Event,
        ]);
    }

    public function store(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'location' => 'nullable|string',
                'audience' => 'enum:'.Audience::class,
                'category' => 'enum:'.Category::class,
                'grades' => 'sometimes|array',
                'grades.*' => 'enum:'.Grade::class,
                'standards' => 'sometimes|array',
                'standards.*' => 'enum:'.Standard::class,
                'practices' => 'sometimes|array',
                'practices.*' => 'enum:'.Practice::class,
                'languages' => 'sometimes|array',
                'languages.*' => 'enum:'.Language::class,
                'start' => 'required|date_format:H:i',
                'end' => 'required|date_format:H:i',
                'days' => 'required|array',
                'days.*.date' => 'required|date',
            ]);

            data_fill($validated, 'days', [['date' => Carbon::today()]]);
            $validated['description'] = Editor::fromJson($validated['description']);
            $validated['metadata'] = new Metadata($validated);

            $event = $user->events()->create(Arr::except($validated, 'days'));
            $event->days()->createMany($validated['days']);

            return to_route('users.events.edit', ['me', $event]);
        } catch (\Throwable $th) {
            report($th);

            return session_back()->with('error', _('An error occured when saving the event.'));
        }
    }

    public function edit(Request $request, User $user, Event $event)
    {
        return view('users.events.edit', [
            'user' => $user,
            'event' => $event,
        ]);
    }

    public function update(Request $request, User $user, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'audience' => 'enum:'.Audience::class,
            'category' => 'enum:'.Category::class,
            'grades' => 'sometimes|array',
            'grades.*' => 'enum:'.Grade::class,
            'standards' => 'sometimes|array',
            'standards.*' => 'enum:'.Standard::class,
            'practices' => 'sometimes|array',
            'practices.*' => 'enum:'.Practice::class,
            'languages' => 'sometimes|array',
            'languages.*' => 'enum:'.Language::class,
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'days' => 'required|array',
            'days.*.date' => 'required|date',
        ]);

        data_fill($validated, 'days', [['date' => Carbon::today()]]);
        $validated['description'] = Editor::fromJson($validated['description']);
        $validated['metadata'] = new Metadata($validated);

        $event->update(Arr::except($validated, 'days'));

        $event->days()->delete();
        $event->days()->createMany($validated['days']);

        return to_route('users.events.edit', ['me', $event]);
    }

    public function destroy(User $user, Event $event)
    {
        if ($event->attendees_count > 0) {
            return session_back()->with('error', __('Event has attendees'));
        }

        $successful = $event->delete();

        return session_back()->with($successful ? 'success' : 'error', $successful ? __('Event successfully cancelled') : __('Failed to cancel event'));
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('owner', only: ['create', 'store']),
            new Middleware('owner:event', only: ['edit', 'update', 'destroy']),
            new Middleware('verified', except: ['index']),
        ];
    }
    // public function index(Request $request, User $user)
    // {
    //     $events = $user->events()->get();
    //     return view("users.events.index", compact("events", "user"));
    // }

    // public function create(User $user)
    // {
    //     // return view('users.events.create');
    //     // $this->authorize('create', [Event::class, $user]);
    //     return view('users.events.create', compact('user'));
    // }

    // public function store(StoreEventRequest $request, User $user)
    // {
    //     $validated = $request->validated();
    //     $validated["is_all_day"] = isset($validated["is_all_day"]);
    //     $validated["metadata"] = new Metadata($validated["metadata"]);
    //     $validated["location"] = $validated["location"] ?? "";
    //     $validated["start_time"] =  data_get($validated, "start_time");
    //     $validated["end_time"] =  data_get($validated, "end_time");
    //     $validated["start"] = Event::combineDateAndTime($validated["start_date"], $validated["start_time"]);
    //     $validated["end"] = is_null($validated['end_date']) ? null : Event::combineDateAndTime($validated["end_date"], $validated["end_time"]);
    //     $validated["description"] = Editor::fromJson($validated["description"]);
    //     unset($validated["start_date"], $validated["end_date"], $validated["start_time"], $validated["end_time"]);

    //     $event = $user->events()->create($validated);

    //     return redirect(route('users.events.edit', [$user, $event]))->with("success", __("Event successfully created"));
    // }

    // public function edit(User $user, Event $event)
    // {
    //     return view('users.events.edit', compact('user', 'event'));
    //     // $this->authorize("update", [Event::Class, $user]);
    //     // return view("users.events.edit", compact("user", "events"));
    // }

    // public function update(UpdateEventRequest $request, User $user, Event $event)
    // {
    //     $validated = $request->validated();
    //     $validated["metadata"] = new Metadata($validated["metadata"]);
    //     $validated["location"] = $validated["location"] ?? "";
    //     $validated["is_all_day"] = isset($validated["is_all_day"]);
    //     $validated["start_time"] =  data_get($validated, "start_time");
    //     $validated["end_time"] =  data_get($validated, "end_time");
    //     $validated["start"] = Event::combineDateAndTime($validated["start_date"], $validated["start_time"]);
    //     $validated["end"] = is_null($validated['end_date']) ? null : Event::combineDateAndTime($validated["end_date"], $validated["end_time"]);
    //     $validated["description"] = Editor::fromJson($validated["description"]);
    //     unset($validated["start_date"], $validated["end_date"], $validated["start_time"], $validated["end_time"]);

    //     $event->update($validated);
    //     return session_back()->with("success", __("Event successfully updated"));
    // }

    // public function destroy(User $user, Event $event)
    // {
    //     $successful = $event->delete();
    //     if ($successful) {
    //         return redirect()
    //             ->route('users.events.index', [$user, $event])
    //             ->with('success', __('Event successfully cancelled'));
    //     }
    // }
}
