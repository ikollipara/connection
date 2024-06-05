<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\PostCollection;
use Livewire\Component;

class AddCollectionRow extends Component
{
    public PostCollection $collection;
    public Post $post;
    public bool $has_post = false;

    public function mount(PostCollection $collection, Post $post): void
    {
        $this->collection = $collection;
        $this->post = $post;
        $this->has_post = $collection
            ->entries()
            ->where("content_id", $post->id)
            ->exists();
    }

    public function add(): void
    {
        $this->collection->entries()->attach($this->post);
        $this->has_post = true;
        $this->dispatchBrowserEvent("success", [
            "message" => "Post added to collection successfully!",
        ]);
    }

    public function remove(): void
    {
        $this->collection->entries()->detach($this->post);
        $this->has_post = false;
        $this->dispatchBrowserEvent("success", [
            "message" => "Post removed from collection successfully!",
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.add-collection-row");
    }
}
