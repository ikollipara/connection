<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Post;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Js;

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

    public function store(Request $request, User $user)
    {
        $body = $request->input('body', '');
        $title = $request->input('title', '');

        try {
            $post = $user->posts()->create([
                'title' => $title,
                'body' => Editor::fromJson($body),
            ]);

            info('Post created', ['post' => $post, 'user' => $user]);

            return redirect()->route('users.posts.edit', [$user, $post])->with('success', 'Post created successfully');
        } catch (\Throwable $th) {
            return session_back()->with('error', 'Post creation failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Post $post)
    {
        return view('users.posts.edit', ['user' => $user, 'post' => $post]);
    }

    public function update(Request $request, User $user, Post $post)
    {
        $body = $request->input('body', Js::encode($post->body));
        $title = $request->input('title', $post->title);

        try {
            $post->update([
                'title' => $title,
                'body' => Editor::fromJson($body),
            ]);

            info('Post updated', ['post' => $post, 'user' => $user]);

            return redirect()->route('users.posts.edit', [$user, $post])->with('success', 'Post updated successfully');
        } catch (\Throwable $th) {
            logger()->error('Post update failed', ['user' => $user, 'post' => $post, 'error' => $th->getMessage()]);

            return session_back()->with('error', 'Post update failed');
        }
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('owner', only: ['index', 'create', 'store']),
            new Middleware('owner:post', only: ['edit', 'update']),
        ];
    }
}
