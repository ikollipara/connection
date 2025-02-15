<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ContentCollection;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ContentCollectionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, ContentCollection $collection): View
    {

        $collection->view();

        return view('collections.show', [
            'collection' => $collection->load('user.profile'),
        ]);
    }

    public static function middleware(): array
    {
        return [];
    }
}
