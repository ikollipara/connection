<?php

namespace App\Http\Controllers;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Models\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(private Search $search)
    {
        //
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'q' => 'sometimes|nullable|string',
            'type' => 'sometimes|in:post,collection,event,user',
            'views' => 'sometimes|integer|min:0',
            'likes' => 'sometimes|integer|min:0',
            'audiences' => 'sometimes|array',
            'audiences.*' => 'enum:'.Audience::class,
            'categories' => 'sometimes|array',
            'categories.*' => 'enum:'.Category::class,
            'grades' => 'sometimes|array',
            'grades.*' => 'enum:'.Grade::class,
            'standards' => 'sometimes|array',
            'standards.*' => 'enum:'.Standard::class,
            'practices' => 'sometimes|array',
            'practices.*' => 'enum:'.Practice::class,
            'languages' => 'sometimes|array',
            'languages.*' => 'enum:'.Language::class,
        ]);

        $results = match(true) {
            $request->has('q') => $this->search->search($validated),
            default => collect(),
        };

        return view('search.index', [
            'results' => $results,
        ]);
    }

    public static function middleware(): array
    {
        return [
            //
        ];
    }
}
