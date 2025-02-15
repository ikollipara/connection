<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Models\Post;
use App\Models\User;
use App\ValueObjects\Metadata;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class UserPostPublishController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'audience' => 'enum:' . Audience::class,
            'category' => 'enum:' . Category::class,
            'grades' => 'sometimes|array',
            'grades.*' => 'enum:' . Grade::class,
            'standards' => 'sometimes|array',
            'standards.*' => 'enum:' . Standard::class,
            'practices' => 'sometimes|array',
            'practices.*' => 'enum:' . Practice::class,
            'languages' => 'sometimes|array',
            'languages.*' => 'enum:' . Language::class,
        ]);

        $post->metadata = new Metadata($validated);
        $post->published = true;

        $successful = $post->save();

        return to_route('users.posts.edit', ['me', $post])->with($post->was_recently_published ? 'published' : 'saved', $successful);
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
            function (Request $request, Closure $next) {
                if (($requestUser = $request->route('user')) && $requestUser instanceof Model && (! $request->user()?->is($requestUser))) {
                    return session_back()->with('error', 'You are not authorized to perform this action.');
                }

                return $next($request);
            },
        ];
    }
}
