<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentLikeRequest;
use App\Models\Comment;
use App\Models\Likes\CommentLike;

class CommentCommentLikesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentLikeRequest $request, Comment $comment)
    {
        $validated = $request->validated();
        $comment
            ->likes()
            ->where('user_id', $validated['user_id'])
            ->updateOrCreate($validated)
            ->touch();

        return back(303)->with('success', __('Comment liked.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, CommentLike $commentLike)
    {
        $commentLike->delete();

        return back(303)->with('success', __('Comment like removed.'));
    }
}
