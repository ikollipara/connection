<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Routing\Controllers\Middleware;

final class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        $successful = mail(config('mail.maintainer'), $validated['subject'], $validated['message'], 'From: ' . $validated['email']);

        if ($successful) {
            return to_route('contact')->with('success');
        }

        return to_route('contact')->with('error');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('guest'),
        ];
    }
}
