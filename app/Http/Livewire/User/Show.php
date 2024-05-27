<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\Concerns\LazyLoading;
use App\Models\PostCollection;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    use LazyLoading;
    public User $user;
    public string $bio;
    protected $lazy = ["collections", "posts"];

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->bio = json_encode($user->bio);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Post>
     */
    public function getTopPostsProperty()
    {
        if (!$this->ready_to_load_posts) {
            return collect();
        }
        return $this->user
            ->posts()
            ->wherePublished()
            ->orderByDesc("likes_count")
            ->orderByDesc("views")
            ->limit(10)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\PostCollection>
     */
    public function getTopCollectionsProperty()
    {
        if (!$this->ready_to_load_collections) {
            return collect();
        }
        return PostCollection::query()
            ->where("user_id", $this->user->id)
            ->withCount("posts")
            ->wherePublished()
            ->orderByDesc("likes_count")
            ->orderByDesc("views")
            ->limit(10)
            ->get();
    }

    public function follow(User $user): void
    {
        if ($user->follow($this->user)) {
            $this->dispatchBrowserEvent("success", [
                "message" => __("Followed!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to follow!"),
            ]);
        }
    }

    public function unfollow(User $user): void
    {
        if ($user->unfollow($this->user)) {
            $this->dispatchBrowserEvent("success", [
                "message" => __("Unfollowed!"),
            ]);
        } else {
            $this->dispatchBrowserEvent("error", [
                "message" => __("Failed to unfollow!"),
            ]);
        }
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.user.show");
    }
}
