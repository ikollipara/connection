<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, Post $post)
    {

        $post->view();

        return view('posts.show', [
            'post' => $post->load('user.profile'),
        ]);
    }

    public static function middleware(): array
    {
        return [];
    }
}
