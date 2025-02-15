<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Models\Event;
use App\Models\User;
use App\ValueObjects\Editor;
use App\ValueObjects\Metadata;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

final class UserEventController extends Controller
{
    public function index(Request $request, User $user): View
    {
        $q = $request->query('q', '');
        $events = $user->events()->search($q)->withCount(['days', 'attendees'])->paginate(15);

        return view('users.events.index', [
            'events' => $events,
        ]);
    }

    public function create(Request $request, User $user): View
    {
        return view('users.events.create', [
            'user' => $user,
            'event' => new Event,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'audience' => 'enum:' . Audience::class,
            'category' => 'enum:' . Category::class,
            'grades' => 'sometimes|array',
            'grades.*' => 'enum:' . Grade::class,
            'standards' => 'sometimes|array',
            'standards.*' => 'enum:' . Standard::class,
            'practices' => 'sometimes|array',
            'practices.*' => 'enum:' . Practice::class,
            'languages' => 'sometimes|array',
            'languages.*' => 'enum:' . Language::class,
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'days' => 'required|array',
            'days.*.date' => 'required|date',
        ]);


        data_fill($validated, 'days', [['date' => Carbon::today()]]);
        $validated['description'] = Editor::fromJson($validated['description']);
        $validated['metadata'] = new Metadata($validated);


        [$result, $event] = DB::transaction(function () use ($validated, $user) {
            $event = $user->events()->make(Arr::except($validated, 'days'));
            $result = $event->save();
            $event->days()->createMany($validated['days']);
            return [$result, $event];
        });

        if ($result) return to_route('users.events.edit', ['me', $event]);
        return session_back()->with('error', _('An error occured when saving the event.'));
    }

    public function edit(Request $request, User $user, Event $event): View
    {
        return view('users.events.edit', [
            'user' => $user,
            'event' => $event,
        ]);
    }

    public function update(Request $request, User $user, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'audience' => 'enum:' . Audience::class,
            'category' => 'enum:' . Category::class,
            'grades' => 'sometimes|array',
            'grades.*' => 'enum:' . Grade::class,
            'standards' => 'sometimes|array',
            'standards.*' => 'enum:' . Standard::class,
            'practices' => 'sometimes|array',
            'practices.*' => 'enum:' . Practice::class,
            'languages' => 'sometimes|array',
            'languages.*' => 'enum:' . Language::class,
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'days' => 'required|array',
            'days.*.date' => 'required|date',
        ]);

        data_fill($validated, 'days', [['date' => Carbon::today()]]);
        $validated['description'] = Editor::fromJson($validated['description']);
        $validated['metadata'] = new Metadata($validated);

        DB::transaction(function () use ($event, $validated) {
            $event->update(Arr::except($validated, 'days'));

            $event->days()->delete();
            $event->days()->createMany($validated['days']);
        });


        return to_route('users.events.edit', ['me', $event]);
    }

    public function destroy(User $user, Event $event): RedirectResponse
    {
        if ($event->attendees()->count() > 0) {
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
}
