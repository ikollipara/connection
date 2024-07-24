<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

class UserFollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $user = $user->loadCount(["followers", "following"])->load("profile");
        $followers = $user
            ->followers()
            ->withCount(["posts", "collections"])
            ->paginate(15);

        return view("users.followers.index", compact("user", "followers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            "user_id" => "required|string|exists:users,id",
        ]);
        $user->followers()->attach($validated["user_id"]);
        return redirect(route("users.show", $user), 303);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $follower
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, User $follower)
    {
        $user->followers()->detach($follower);
        return redirect(route("users.show", $user), 303);
    }
}
