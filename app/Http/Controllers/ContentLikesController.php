<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContentLikeRequest;
use App\Models\Content;
use App\Models\Likes\ContentLike;
use Illuminate\Http\Request;

class ContentLikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function index(Content $content)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function create(Content $content)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContentLikeRequest  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentLikeRequest $request, Content $content)
    {
        $validated = $request->validated();
        $content->likes()->create($validated);
        return back(303)->with("success", __("{$content->name} liked"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @param  \App\Models\Likes\ContentLike  $contentLike
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content, ContentLike $contentLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @param  \App\Models\Likes\ContentLike  $contentLike
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content, ContentLike $contentLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @param  \App\Models\Likes\ContentLike  $contentLike
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        Content $content,
        ContentLike $contentLike
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @param  \App\Models\Likes\ContentLike  $contentLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content, ContentLike $contentLike)
    {
        $successful = $contentLike->delete();
        if ($successful) {
            return back(303)->with("success", __("Like removed successfully"));
        }
    }
}
