<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

final class UserFollowerController extends Controller
{
    public function index(Request $request, User $user): View
    {
        $followers = $user->followers()->get();

        $followers->each->load('profile');

        return view('users.followers.index', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'follower_id' => 'required|exists:users,id',
        ]);

        $user->followers()->attach($validated['follower_id']);

        return session_back(status: Response::HTTP_SEE_OTHER)->with('success', 'User followed successfully');
    }

    public function destroy(User $user, User $follower): RedirectResponse
    {
        $user->followers()->detach($follower);

        return session_back(status: Response::HTTP_SEE_OTHER)->with('success', 'User unfollowed successfully');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index']),
            new Middleware('verified', except: ['index']),
        ];
    }
}
