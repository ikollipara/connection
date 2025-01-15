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
     * @return \Illuminate\Http\Response
     */
    public function index(PostCollection $postCollection)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PostCollection $postCollection)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreEntryRequest $request,
        PostCollection $postCollection
    ) {
        $validated = $request->validated();
        $postCollection->entries()->attach($validated['content_id']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PostCollection $postCollection, Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCollection $postCollection, Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCollection $postCollection, Entry $entry)
    {
        $successful = $entry->delete();
        if ($successful) {
            return session_back()->with('success', __('Entry deleted successfully'));
        }

        return back(500)->with('error', __('Failed to delete entry'));
    }
}
