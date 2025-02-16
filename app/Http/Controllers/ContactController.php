<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Mail;

final class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Mail::to(config('mail.maintainer'))->queue(new Contact($validated['email'], $validated['subject'], $validated['message']));

        return to_route('contact')->with('success');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('guest'),
        ];
    }
}
