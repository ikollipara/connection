<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContentContentCollectionController extends Controller
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

        try {
            $content->collections()->sync($collections);

            return response()->noContent();
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response(
                content: ['message' => $message],
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
