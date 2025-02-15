<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

final class EventController extends Controller
{
    public function index(Request $request): View
    {
        return view('events.index', [
            'mine' => $request->has('attending'),
        ]);
    }

    public function show(Event $event): View
    {
        $event->view();

        return view('events.show', [
            'event' => $event,
        ]);
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['index']),
        ];
    }
}
