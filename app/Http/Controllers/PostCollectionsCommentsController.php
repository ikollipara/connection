<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class PostCollectionsCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostCollection $postCollection)
    {
        $comments = $postCollection
            ->comments()
            ->latest()
            ->paginate(10);

        return view(
            'collections.comments.index',
            compact('postCollection', 'comments'),
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PostCollection $postCollection)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreCommentRequest $request,
        PostCollection $postCollection
    ) {
        $validated = $request->validated();
        $comment = $postCollection->comments()->create($validated);

        return session_back()->with('success', __('Comment successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PostCollection $postCollection, Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCollection $postCollection, Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        PostCollection $postCollection,
        Comment $comment
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCollection $postCollection, Comment $comment)
    {
        //
    }
}
