<?php

namespace App\Http\Controllers;

use App\Enums\Grade;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display the resource.
     */
    public function show(User $user)
    {
        $profile = $user->profile;
        $user = $user->loadCount([
            'posts' => fn($query) => $query->areSearchable(),
            'collections' => fn($query) => $query->areSearchable(),
            'followers',
            'following',
        ]);

        if (! $user->is(Auth::user())) {
            $profile->view();
        }

        return view('users.profile.show', [
            'profile' => $profile,
            'user' => $user,
            'postCount' => $user->posts_count,
            'collectionCount' => $user->collections_count,
            'followerCount' => $user->followers_count,
            'followingCount' => $user->following_count,
        ]);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(User $user)
    {
        $profile = $user->profile;

        return view('users.profile.edit', [
            'profile' => $profile,
            'user' => $user,
        ]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'school' => 'string',
            'subject' => 'string',
            'years_of_experience' => 'sometimes|integer|min:0',
            'grades' => 'array',
            'grades.*' => 'enum:' . Grade::class,
            'bio' => 'json',
            'consented.full_name' => 'nullable|string',
        ]);

        DB::transaction(function () use ($user, $validated) {
            $user->consented = filled(data_get($validated, 'consented.full_name'));
            $user->profile()->update(Arr::except($validated, 'consented'));
            $user->save();
        });

        return to_route('users.profile.edit', $user, status: Response::HTTP_SEE_OTHER)->with('success', 'Profile updated successfully');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['edit', 'update']),
            new Middleware('owner', only: ['edit', 'update']),
        ];
    }
}
