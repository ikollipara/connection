<?php

namespace App\Http\Handlers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Content;
use App\Services\SearchService;
use Illuminate\Http\Request;

class ContentSearchHandler extends Controller
{
    protected SearchService $search_service;

    public function __construct(SearchService $search_service)
    {
        $this->search_service = $search_service;
        $this->search_service->setModel(Content::class);
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SearchRequest $request)
    {
        $validated = $request->validated();
        $results = collect();
        if (filled($validated)) {
            $this->logSearch($request, $validated);
            $results = $this->search_service->search($validated);
        }

        session()->flashInput($validated);

        return view('search', compact('results'));
    }

    private function logSearch($request, $validated)
    {
        $request
            ->user()
            ->searches()
            ->create([
                'search_params' => json_encode(array_merge($validated, ['model' => Content::class])),
            ]);
    }
}
