<?php

namespace App\Http\Livewire;

use App\Contracts\Likable;
use App\Http\Livewire\Concerns\LazyLoading;
use Livewire\Component;

class LikeButton extends Component
{
    use LazyLoading;

    public $likable;
    public bool $liked = false;

    public $lazy = ["likes"];

    public function mount($likable): void
    {
        $this->likable = $likable;
        $this->liked = $this->likable
            ->likes()
            ->where("user_id", auth()->id())
            ->exists();
    }

    public function getLikesProperty(): int
    {
        if (!$this->ready_to_load_likes) {
            return 0;
        }
        return $this->likable->likes()->count();
    }

    public function toggleLike(): void
    {
        if ($this->liked) {
            $this->unlike();
        } else {
            $this->like();
        }
    }

    public function like(): void
    {
        $this->likable->likes()->create(["user_id" => auth()->id()]);
        $this->liked = true;
        $this->dispatchBrowserEvent("success", [
            "message" => __("Liked!"),
        ]);
    }

    public function unlike(): void
    {
        $this->likable
            ->likes()
            ->where("user_id", auth()->id())
            ->delete();
        $this->liked = false;
        $this->dispatchBrowserEvent("success", [
            "message" => __("Unliked!"),
        ]);
    }

    public function render()
    {
        return view("livewire.like-button");
    }
}
