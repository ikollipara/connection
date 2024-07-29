<?php

namespace App\Http\Handlers;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class DashboardHandler extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $top_content = Content::query()
            ->topLastMonth()
            ->limit(10)
            ->get();
        $new_follower_content = Content::query()
            ->whereIn(
                'user_id',
                auth()
                    ->user()
                    ->following()
                    ->pluck('followed_id'),
            )
            ->wherePublished()
            ->latest()
            ->limit(10)
            ->get();

        return view(
            'dashboard',
            compact('top_content', 'new_follower_content'),
        );
    }
}
