<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

final class AuthenticatedUserController extends Controller
{
    public function create(): View
    {
        return view('auth.sessions.create');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::whereEmail($validated['email'])->first()?->sendLoginLink();

        return to_route('login')->with('success', 'Check your email for the login link.');
    }

    public function show(User $user): RedirectResponse
    {
        data_fill($user, 'email_verified_at', now());
        $user->save();

        Auth::login($user, remember: true);
        Session::regenerate();

        return to_route('user.feed', 'me');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();
        Session::regenerate();

        return to_route('login');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['destroy']),
            new Middleware('guest', except: ['destroy']),
        ];
    }
}
