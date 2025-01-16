<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\ValueObjects\Editor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class UserPostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $body = $request->input('body', '');
        $title = $request->input('title', '');

        try {
            $post = $user->posts()->create([
                'title' => $title,
                'body' => Editor::fromJson($body),
            ]);

            info('Post created', ['post' => $post, 'user' => $user]);

            return response(
                content: [
                    'formAction' => route('api.users.posts.update', [$user, $post]),
                    'drawerAction' => route('users.posts.publish', [$user, $post]),
                    'url' => route('users.posts.edit', [$user, $post]),
                    'title' => $post->title,
                ],
                status: Response::HTTP_CREATED,
            );
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            logger()->error('Post creation failed', ['user' => $user, 'error' => $message]);

            return response(
                content: [
                    'message' => $message,
                ],
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, Post $post)
    {
        $body = $request->input('body', json_encode($post->body));
        $title = $request->input('title', $post->title);

        try {
            $post->update([
                'title' => $title,
                'body' => Editor::fromJson($body),
            ]);

            info('Post updated', ['post' => $post, 'user' => $user]);

            return response(
                content: [
                    'formAction' => route('api.users.posts.update', [$user, $post]),
                    'drawerAction' => route('users.posts.publish', [$user, $post]),
                    'url' => route('users.posts.edit', [$user, $post]),
                    'title' => $post->title,
                ],
                status: Response::HTTP_OK,
            );
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            logger()->error('Post creation failed', ['user' => $user, 'error' => $message]);

            return response(
                content: [
                    'message' => $message,
                ],
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    public static function middleware(): array
    {
        return [
            //
        ];
    }
}
