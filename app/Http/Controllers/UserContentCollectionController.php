<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\ContentCollection;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class UserContentCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $status = Status::tryFrom($request->query('status', 'draft')) ?? Status::draft();
        $q = $request->query('q');

        $collections = $user->collections()->search($q)->status($status)->latest()->paginate(15)->withQueryString();

        return view('users.collections.index', [
            'collections' => $collections,
            'status' => $status,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('users.collections.create', ['user' => $user, 'collection' => new ContentCollection]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, ContentCollection $collection)
    {
        return view('users.collections.edit', ['user' => $user, 'collection' => $collection->load('entries')]);
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            function (Request $request, Closure $next) {
                if (! $request->route()->parameter('user')->is(Auth::user())) {
                    return to_route('users.collections.index', ['user' => 'me']);
                }

                return $next($request);
            },
        ];
    }
}
