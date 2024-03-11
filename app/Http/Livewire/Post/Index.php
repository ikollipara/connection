<?php

namespace App\Http\Livewire\Post;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $status = "draft";
    public string $search = "";
    public bool $ready_to_load_posts = false;

    public function mount(): void
    {
        $this->authorize("viewAny", auth()->user());
        $this->status = request()->query("status", "draft");
    }

    public function loadPosts(): void
    {
        $this->ready_to_load_posts = true;
    }

    public function getPostsProperty(): LengthAwarePaginator
    {
        if (!$this->ready_to_load_posts) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                0,
                10,
                $this->page,
            );
        }
        return auth()
            ->user()
            ->posts()
            ->status($this->status)
            ->when($this->search !== "", function ($query) {
                return $query->where("title", "like", "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);
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

    /** @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory */
    public function render()
    {
        $status = Str::title($this->status);
        return view("livewire.post.index")->layoutData([
            "title" => "ConneCTION " . __("{$status} Posts"),
        ]);
    }
}
