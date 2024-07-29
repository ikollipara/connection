<?php

namespace App\Http\Controllers;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Status;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use App\ValueObjects\Metadata;
use Illuminate\Http\Request;

class UserPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\User  $user
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        $this->authorize("viewAny", [Post::class, $user]);
        if ($user->isNot(auth()->user())) {
            return redirect()->route("users.posts.index", ["me"], 303);
        }
        $status =
            Status::tryFrom($request->query("status", "draft")) ??
            Status::draft();
        $q = $request->query("q");
        $posts = $user
            ->posts()
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
            "users.posts.index",
            compact("posts", "status", "q", "user"),
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
        $this->authorize("create", [Post::class, $user]);
        return view("users.posts.create", compact("user"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated["published"] = $validated["published"] == "1";
        $validated["metadata"] = new Metadata($validated["metadata"]);
        $post = $user->posts()->create($validated);

        return redirect()
            ->route("users.posts.edit", [$user, $post])
            ->with("success", __("Post successfully created"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Post $post)
    {
        $this->authorize("update", [$post, $user]);
        return view("users.posts.edit", compact("user", "post"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, User $user, Post $post)
    {
        $validated = $request->validated();
        if (isset($validated["archive"])) {
            $should_archive = $validated["archive"] == "1";
            $post->{$should_archive ? "delete" : "restore"}();
            return back()->with(
                "success",
                __(
                    "Post successfully " .
                        ($should_archive ? "archived" : "restored"),
                ),
            );
        }
        $validated["published"] = $validated["published"] == "1";
        $validated["metadata"] = new Metadata($validated["metadata"]);
        $post->update($validated);
        return redirect(route("users.posts.edit", [$user, $post]), 303)->with(
            "success",
            __("Post successfully updated"),
        );
    }
}
