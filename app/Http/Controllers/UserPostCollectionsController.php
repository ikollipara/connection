<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\StorePostCollectionRequest;
use App\Http\Requests\UpdatePostCollectionRequest;
use App\Models\PostCollection;
use App\Models\User;
use App\ValueObjects\Metadata;
use Illuminate\Http\Request;

class UserPostCollectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize("viewAny", [PostCollection::class, $user]);
        if ($user->isNot(auth()->user())) {
            return redirect()->route("users.collections.index", ["me"], 303);
        }
        $status =
            Status::tryFrom(request()->query("status", "draft")) ??
            Status::draft();
        $q = request()->query("q");
        $collections = $user
            ->collections()
            ->when($q, function ($query, $q) {
                return $query->where("title", "like", "%{$q}%");
            })
            ->status($status)
            ->orderByDesc("created_at")
            ->select([
                "id",
                "title",
                "published",
                "created_at",
                "updated_at",
                "deleted_at",
                "type",
            ])
            ->paginate(10)
            ->withQueryString();

        return view(
            "users.collections.index",
            compact("collections", "status", "q", "user"),
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $this->authorize("create", [PostCollection::class, $user]);
        return view("users.collections.create", compact("user"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostCollectionRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostCollectionRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated["published"] = $validated["published"] == "1";
        $validated["metadata"] = new Metadata($validated["metadata"]);
        $collection = $user->collections()->create($validated);

        return redirect(
            route("users.collections.edit", [$user, $collection]),
            303,
        )->with("success", __("Collection successfully created."));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, PostCollection $postCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, PostCollection $postCollection)
    {
        $this->authorize("update", [$postCollection, $user]);
        return view("users.collections.edit", [
            "user" => $user,
            "collection" => $postCollection->load("entries"),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostCollectionRequest  $request
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdatePostCollectionRequest $request,
        User $user,
        PostCollection $postCollection
    ) {
        $validated = $request->validated();
        if (isset($validated["archive"])) {
            $should_archive = $validated["archive"] == "1";
            $postCollection->{$should_archive ? "delete" : "restore"}();
            return back()->with(
                "success",
                __(
                    "Collection successfully " .
                        ($should_archive ? "archived" : "restored"),
                ),
            );
        }
        $validated["published"] = $validated["published"] == "1";
        $validated["metadata"] = new Metadata($validated["metadata"]);
        $postCollection->update($validated);
        return redirect(
            route("users.collections.edit", [$user, $postCollection]),
            303,
        )->with("success", __("Collection successfully updated."));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostCollection  $postCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, PostCollection $postCollection)
    {
        //
    }
}
