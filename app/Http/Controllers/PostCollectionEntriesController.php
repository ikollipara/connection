<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryRequest;
use App\Models\Entry;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class PostCollectionEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function index(PostCollection $postCollection)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function create(PostCollection $postCollection)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEntryRequest  $request
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreEntryRequest $request,
        PostCollection $postCollection
    ) {
        $validated = $request->validated();
        $postCollection->entries()->attach($validated["content_id"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(PostCollection $postCollection, Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCollection $postCollection, Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostCollection  $postCollection
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        PostCollection $postCollection,
        Entry $entry
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCollection $postCollection, Entry $entry)
    {
        $successful = $entry->delete();
        if ($successful) {
            return back(303)->with("success", __("Entry deleted successfully"));
        }
        return back(500)->with("error", __("Failed to delete entry"));
    }
}
