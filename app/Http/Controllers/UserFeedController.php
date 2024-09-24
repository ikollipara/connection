<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class UserFeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        $feed = Content::query()->whereIn('user_id', $user->following()->pluck('followers.followed_id'))->areSearchable()->latest()->get();

        return view('users.feed', [
            'feed' => $feed,
        ]);
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }
}
