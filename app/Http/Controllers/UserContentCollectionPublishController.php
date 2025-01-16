<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Models\ContentCollection;
use App\Models\User;
use App\ValueObjects\Metadata;
use Closure;
use Illuminate\Http\Request;

final class UserContentCollectionPublishController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, ContentCollection $collection)
    {
        $validated = $request->validate([
            'audience' => 'enum:'.Audience::class,
            'category' => 'enum:'.Category::class,
            'grades' => 'sometimes|array',
            'grades.*' => 'enum:'.Grade::class,
            'standards' => 'sometimes|array',
            'standards.*' => 'enum:'.Standard::class,
            'practices' => 'sometimes|array',
            'practices.*' => 'enum:'.Practice::class,
            'languages' => 'sometimes|array',
            'languages.*' => 'enum:'.Language::class,
        ]);

        $collection->metadata = new Metadata($validated);
        $collection->published = true;

        $successful = $collection->save();

        return to_route('users.collections.edit', ['me', $collection])->with($collection->was_recently_published ? 'published' : 'saved', $successful);
    }

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
            function (Request $request, Closure $next) {
                if (! $request->user()->is($request->route('user'))) {
                    return session_back()->with('error', 'You are not authorized to perform this action.');
                }

                return $next($request);
            },
        ];
    }
}
