<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ContentContentCollectionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Content $content)
    {
        $collections = $request->validate([
            'collections' => 'required|array',
            'collections.*' => 'string|exists:content,id',
        ])['collections'];

        $content->collections()->sync($collections);

        return response()->noContent();
    }
}
