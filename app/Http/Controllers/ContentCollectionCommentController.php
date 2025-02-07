<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ContentCollection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

final class ContentCollectionCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContentCollection $collection)
    {
        $comments = $collection->comments()->root()->get();

        return view('content.comments.index', [
            'content' => $collection,
            'comments' => $comments,
            'action' => route('collections.comments.store', $collection),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ContentCollection $collection)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $collection->comments()->make($validated);
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
