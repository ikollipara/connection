<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ContentCollection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class ContentCollectionCommentController extends Controller
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

        $successful = $collection->comments()->create($validated);

        return session_back()->with('success', $successful ? 'Comment created successfully' : 'Failed to create comment');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentCollection $collection, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentCollection $collection, Comment $comment)
    {
        //
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['store', 'update', 'destroy']),
            new Middleware('verified', only: ['store', 'update', 'destroy']),
        ];
    }
}
