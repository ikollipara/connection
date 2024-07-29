<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        /** @var \App\Models\User */
        $user = auth()->user();

        $post
            ->views()
            ->where('user_id', $user->id)
            ->updateOrCreate([
                'user_id' => $user->id,
            ]);

        return view('posts.show', [
            'post' => $post->load('user.profile'),
            'liked_by_user' => $post
                ->likes()
                ->where('user_id', $user->id)
                ->first(),
        ]);
    }
}
