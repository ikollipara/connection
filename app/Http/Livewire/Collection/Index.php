<?php

namespace App\Http\Livewire\Collection;

use App\Http\Livewire\Concerns\LazyLoading;
use App\Models\PostCollection;
use Livewire\Component;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, LazyLoading;

    public string $status = "draft";
    public string $search = "";
    protected $lazy = ["post_collections"];

    public function mount(): void
    {
        $this->status = request()->query("status", "draft");
    }

    /** @return array<string, string[]|string> */
    public function rules(): array
    {
        return [
            "search" => ["string", "nullable"],
        ];
    }

    public function updatingSearch(string $value): void
    {
        $this->resetPage();
    }

    public function getPostCollectionsProperty(): LengthAwarePaginator
    {
        if (!$this->ready_to_load_post_collections) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                $this->page,
            );
        }
        return PostCollection::query()
            ->where("user_id", auth()->id())
            ->status($this->status)
            ->when(
                $this->search !== "",
                fn($query) => $query->where(
                    "title",
                    "like",
                    "%{$this->search}%",
                ),
            )
            ->latest()
            ->withCount("posts")
            ->paginate(10);
    }

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        $status = Str::title($this->status);
        return view("livewire.collection.index")->layoutData([
            "title" => "ConneCTION " . __("{$status} Collections"),
        ]);
    }
}
