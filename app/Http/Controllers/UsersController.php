<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::createWithProfileAndSettings($request->validated());

        return redirect()
            ->route('login.create')
            ->with('success', __('Your account has been created. Please log in.'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        if ($user->delete()) {
            auth()->logout();
            session()->regenerate();

            return redirect(route('users.create'), 303)->with('success', __('Your account has been deleted.'));
        } else {
            return session_back()->with("error", __("Failed to delete your account."));
        }
    }
}
