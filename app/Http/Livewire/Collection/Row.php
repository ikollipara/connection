<?php

namespace App\Http\Livewire\Collection;

use Livewire\Component;
use App\Models\PostCollection;

class Row extends Component
{
    public PostCollection $post_collection;
    public bool $ready_to_load_number_of_posts = false;

    public function mount(PostCollection $post_collection): void
    {
        $this->post_collection = $post_collection;
    }

    public function getNumberOfPostsProperty(): int
    {
        return $this->post_collection->posts_count;
    }

    public function archive(): void
    {
        if (!$this->post_collection->delete()) {
            $this->dispatchBrowserEvent("error", [
                "message" => "Collection is already archived!",
            ]);
            return;
        }
        $this->dispatchBrowserEvent("collection-removed", [
            "id" => $this->post_collection->id,
        ]);
        $this->dispatchBrowserEvent("success", [
            "message" => "Collection archived successfully!",
        ]);
    }

    public function restore(): void
    {
        if (!$this->post_collection->restore()) {
            $this->dispatchBrowserEvent("error", [
                "message" => "Collection could not be restored!",
            ]);
            return;
        }
        $this->dispatchBrowserEvent("collection-removed", [
            "id" => $this->post_collection->id,
        ]);
        $this->dispatchBrowserEvent("success", [
            "message" => "Collection restored successfully!",
        ]);
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        return view("livewire.collection.row");
    }
}
