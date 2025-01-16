<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class EventICalController extends Controller
{
    public function __invoke(Request $request, ?User $user)
    {
        $calendar = Event::toICalCalendar($user->exists ? $user : null);

        return response(
            content: $calendar->refreshInterval(minutes: 5)->get(),
            status: Response::HTTP_OK,
            headers: [
                'Content-Type' => 'text/calendar',
                'Content-Disposition' => 'attachment; filename="connection-calendar.ics"',
            ]
        );
    }

    public static function middleware(): array
    {
        return [];
    }
}
