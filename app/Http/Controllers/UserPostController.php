<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class UserPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $status = Status::tryFrom($request->query('status', 'draft')) ?? Status::draft();
        $q = $request->query('q');

        $posts = $user->posts()->search($q)->status($status)->latest()->paginate(15)->withQueryString();

        return view('users.posts.index', [
            'posts' => $posts,
            'status' => $status,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('users.posts.create', ['user' => $user, 'post' => new Post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Post $post)
    {
        return view('users.posts.edit', ['user' => $user, 'post' => $post]);
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('owner', only: ['index', 'create']),
            new Middleware('owner:post', only: ['edit']),
        ];
    }
}
