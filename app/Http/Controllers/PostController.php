<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PostController extends Controller
{
    public function show(Request $request, Post $post): View
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
