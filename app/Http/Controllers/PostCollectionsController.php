<?php

namespace App\Http\Controllers;

use App\Models\PostCollection;
use Illuminate\Http\Request;

class PostCollectionsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request, PostCollection $postCollection)
    {
        $this->authorize('view', $postCollection);

        /** @var \App\Models\User */
        $user = $request->user();

        $postCollection
            ->views()
            ->where('user_id', $user->id)
            ->updateOrCreate([
                'user_id' => $user->id,
            ]);

        return view('collections.show', [
            'collection' => $postCollection->load('user.profile'),
            'liked_by_user' => $postCollection
                ->likes()
                ->where('user_id', $user->id)
                ->first(),
        ]);
    }
}
