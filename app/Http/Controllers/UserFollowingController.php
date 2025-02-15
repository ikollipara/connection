<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class UserFollowingController extends Controller
{
    public function __invoke(Request $request, User $user): View
    {
        $following = $user->following()->paginate();

        return view('users.following', [
            'user' => $user,
            'following' => $following,
        ]);
    }
}
