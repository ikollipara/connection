<?php

namespace App\Http\Handlers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class ICalHandler extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {
        $calendar = Event::getICalFor($user);

        return response($calendar->refreshInterval(5)->get(), 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="connection-calendar.ics"',
        ]);
    }
}
