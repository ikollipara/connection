<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCollectionRequest;
use App\Models\PostCollection;
use Illuminate\Http\Request;

class PostCollectionsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\View\View
     */
    public function show(PostCollection $postCollection)
    {
        $this->authorize("view", $postCollection);

        /** @var \App\Models\User */
        $user = $this->current_user();

        $postCollection
            ->views()
            ->where("user_id", $user->id)
            ->updateOrCreate([
                "user_id" => $user->id,
            ]);

        return view("collections.show", [
            "collection" => $postCollection->load("user.profile"),
            "liked_by_user" => $postCollection
                ->likes()
                ->where("user_id", $user->id)
                ->first(),
        ]);
    }
}
