<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

final class PostCommentController extends Controller
{
    public function index(Post $post): View
    {
        $comments = $post->comments()->root()->get();

        return view('content.comments.index', [
            'content' => $post,
            'comments' => $comments,
            'action' => route('posts.comments.store', $post),
        ]);
    }

    public function store(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $post->comments()->make($validated);

        $successful = $comment->save();

        return session_back()->with('success', $successful ? 'Comment created successfully' : 'Failed to create comment');
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['store', 'update', 'destroy']),
            new Middleware('verified', only: ['store', 'update', 'destroy']),
        ];
    }
}
