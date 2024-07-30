<?php

namespace App\Http\Handlers;

use App\Models\Entry;
use App\Models\PostCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Content;

class CollectionsEntryHandler extends Controller
{
    public function __construct()
    {
        //
    }

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "content_id" => "required|exists:content,id",
            "collections" => "sometimes|array",
            "collections.*" => "exists:content,id",
        ]);
        $validated["collections"] = $validated["collections"] ?? [];
        /** @var Content */
        $content = Content::findOrFail($validated["content_id"]);
        $content->collections()->sync($validated["collections"]);
        return session_back()->with("success", __("Entries successfully updated."));
    }
}
