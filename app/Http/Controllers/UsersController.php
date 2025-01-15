<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function create(): View
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::createWithProfileAndSettings($request->validated());

        return redirect()
            ->route('login.create')
            ->with('success', __('Your account has been created. Please log in.'));
    }

    public function show(User $user)
    {
        $user = $user->loadCount(['followers', 'following'])->load('profile');
        $posts = $user
            ->posts()
            ->wherePublished()
            ->orderByDesc('likes_count')
            ->orderByDesc('views')
            ->limit(10)
            ->get();
        $collections = $user
            ->collections()
            ->wherePublished()
            ->orderByDesc('likes_count')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return view('users.show', compact('user', 'posts', 'collections'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        if ($user->delete()) {
            auth()->logout();
            session()->regenerate();

            return redirect(route('users.create'), 303)->with('success', __('Your account has been deleted.'));
        } else {
            return session_back()->with('error', __('Failed to delete your account.'));
        }
    }
}
