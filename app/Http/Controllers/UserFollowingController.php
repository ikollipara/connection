<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;

final class UserFollowingController extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        $following = $user->following()->paginate();

        return view('users.following', [
            'user' => $user,
            'following' => $following,
        ]);
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index(User $user)
    // {
    //     $user = $user->loadCount(['following', 'followers'])->load('profile');
    //     $following = $user
    //         ->following()
    //         ->with('profile')
    //         ->paginate(15);

    //     return view('users.following.index', compact('user', 'following'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create(User $user)
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request, User $user)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(User $user, Follower $follower)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(User $user, Follower $follower)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, User $user, Follower $follower)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(User $user, Follower $follower)
    // {
    //     //
    // }
}
