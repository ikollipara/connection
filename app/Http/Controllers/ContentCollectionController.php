<?php

namespace App\Http\Controllers;

use App\Models\ContentCollection;
use Illuminate\Http\Request;

final class ContentCollectionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, ContentCollection $collection)
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
