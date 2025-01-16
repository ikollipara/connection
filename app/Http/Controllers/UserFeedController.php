<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;

final class UserFeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        $feed = Cache::remember(
            key: "$user->id--feed",
            ttl: now()->addMinutes(5),
            callback: fn () => Content::query()->whereIn('user_id', $user->following()->pluck('followers.followed_id'))->shouldBeSearchable()->latest()->get()
        );

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
