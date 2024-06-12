<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\LazyLoading;
use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Livewire\Component;

class Home extends Component
{
    use LazyLoading;
    protected $lazy = ["top_posts", "top_collections", "followings_items"];

    /** @return \Illuminate\Support\Collection<\App\Models\Post|\App\Models\PostCollection> */
    public function getFollowingsItemsProperty()
    {
        if (!$this->ready_to_load_followings_items) {
            return collect();
        }
        /** @var User */
        $user = auth()->user();

        return $user
            ->load(["following", "following.posts", "following.collections"])
            ->following->flatMap(function (User $user) {
                return [
                    "posts" => $user
                        ->posts()
                        ->where("published", true)
                        ->latest()
                        ->take(10)
                        ->with("user")
                        ->get(),
                    "collections" => $user
                        ->collections()
                        ->where("published", true)
                        ->latest()
                        ->take(10)
                        ->with("user")
                        ->get(),
                ];
            })
            ->flatten();
    }

    /** @return \Illuminate\Database\Eloquent\Collection<\App\Models\Post> */
    public function getTopPostsProperty()
    {
        if (!$this->ready_to_load_top_posts) {
            return collect();
        }
        return Post::query()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->take(10)
            ->with("user")
            ->get();
    }

    /** @return \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection> */
    public function getTopCollectionsProperty()
    {
        if (!$this->ready_to_load_top_collections) {
            return collect();
        }
        return PostCollection::query()
            ->where("published", true)
            ->orderBy("likes_count", "desc")
            ->orderBy("views", "desc")
            ->take(10)
            ->with("user")
            ->get();
    }

    public function render()
    {
        return view("livewire.home")->layoutData([
            "title" => "ConneCTION - " . __("Home"),
        ]);
    }
}
