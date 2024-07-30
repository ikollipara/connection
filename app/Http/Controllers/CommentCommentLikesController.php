<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentLikeRequest;
use App\Models\Comment;
use App\Models\Likes\CommentLike;
use Illuminate\Http\Request;

class CommentCommentLikesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentLikeRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentLikeRequest $request, Comment $comment)
    {
        $validated = $request->validated();
        $comment
            ->likes()
            ->where("user_id", $validated["user_id"])
            ->updateOrCreate($validated)
            ->touch();
        return session_back()->with("success", __("Comment liked."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @param  \App\Models\Likes\CommentLike  $commentLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, CommentLike $commentLike)
    {
        $commentLike->delete();
        return session_back()->with("success", __("Comment like removed."));
    }
}
