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
     * @return \Illuminate\Http\Response
     */
    public function index(Content $content)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Content $content)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentLikeRequest $request, Content $content)
    {
        $validated = $request->validated();
        $content->likes()->create($validated);
        $route = $content->type === 'post' ? 'posts.show' : 'collections.show';

        return redirect(route($route, $content), 303)->with(
            'success',
            __("{$content->name} liked"),
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content, ContentLike $contentLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content, ContentLike $contentLike)
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
        Content $content,
        ContentLike $contentLike
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content, ContentLike $contentLike)
    {
        $successful = $contentLike->delete();
        $route = $content->type === 'post' ? 'posts.show' : 'collections.show';
        if ($successful) {
            return redirect(route($route, $content), 303)->with(
                'success',
                __('Like removed successfully'),
            );
        }
    }
}
