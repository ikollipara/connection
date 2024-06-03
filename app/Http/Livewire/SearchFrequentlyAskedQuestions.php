<?php

namespace App\Http\Livewire;

use App\Models\FrequentlyAskedQuestion;
use Livewire\Component;
use Livewire\WithPagination;

class SearchFrequentlyAskedQuestions extends Component
{
    use WithPagination;

    public $search;

    protected $queryString = [
        "search" => ["except" => "", "as" => "q"],
        "page" => ["except" => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getQuestionsProperty()
    {
        return FrequentlyAskedQuestion::query()
            ->answered()
            ->when(
                filled($this->search),
                fn($query) => $query
                    ->where("title", "like", "%{$this->search}%")
                    ->orWhere("content", "like", "%{$this->search}%")
                    ->orWhere("answer", "like", "%{$this->search}%"),
            )
            ->paginate(15);
    }

    public function render()
    {
        return view("livewire.search-frequently-asked-questions");
    }
}
