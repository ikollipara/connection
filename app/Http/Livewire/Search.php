<?php

namespace App\Http\Livewire;

use App\Enums\Standard;
use App\Enums\StandardGroup;
use App\Models\Content;
use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    /** @var string */
    public $query = "";
    public string $type = "";
    private array $results;
    /** @var array<\App\Enums\Category> */
    public array $categories = [];
    /** @var array<\App\Enums\Audience> */
    public array $audiences = [];
    /** @var array<\App\Enums\Grade> */
    public array $grades = [];
    /** @var array<\App\Enums\Standard> */
    public array $standards = [];
    /** @var array<\App\Enums\Practice> */
    public array $practices = [];
    /** @var array<\App\Enums\Language> */
    public array $languages = [];
    /** @var string[] */
    public array $standard_groups = [];
    public int $likes_count = 0;
    public int $views_count = 0;

    public function mount(): void
    {
        $this->results = [];
    }

    public function search(): void
    {
        auth()
            ->user()
            /** @phpstan-ignore-next-line */
            ->searches()
            ->create([
                "search_params" => json_encode([
                    "query" => $this->query,
                    "type" => $this->type ? $this->type : "both",
                    "categories" => $this->categories,
                    "audiences" => $this->audiences,
                    "grades" => $this->grades,
                    "standards" => $this->standards,
                    "practices" => $this->practices,
                    "languages" => $this->languages,
                    "standard_groups" => $this->standard_groups,
                    "likes_count" => $this->likes_count,
                    "views_count" => $this->views_count,
                ]),
            ]);

        $constraints = [
            "type" => $this->type,
            "categories" => $this->categories,
            "audiences" => $this->audiences,
            "grades" => $this->grades,
            "standards" => $this->standards,
            "practices" => $this->practices,
            "languages" => $this->languages,
            "standard_groups" => $this->standard_groups,
            "likes_count" => $this->likes_count,
            "views_count" => $this->views_count,
        ];

        $this->results = Content::search($this->query)
            ->query(
                fn($query) => $this->applySearchConstraints(
                    $query,
                    $constraints,
                ),
            )
            ->get()
            ->toArray();
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view("livewire.search", [
            "results" => $this->results,
        ])->layoutData([
            "title" => "ConneCTION - " . __("Search"),
        ]);
    }

    // Private

    private function applySearchConstraints($query, array $constraints)
    {
        return $query
            ->where("published", true)
            ->when(
                mb_strlen($constraints["type"]) > 0,
                fn($query) => $query->where("type", $constraints["type"]),
            )
            ->when(
                count($constraints["grades"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->grades",
                    $constraints["grades"],
                ),
            )
            ->when(
                count($constraints["standards"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->standards",
                    $constraints["standards"],
                ),
            )
            ->when(count($constraints["standard_groups"]) > 0, function (
                $query
            ) use ($constraints) {
                $standards = collect($constraints["standard_groups"])
                    ->map(
                        fn($group) => Standard::getGroup(
                            StandardGroup::from($group),
                        ),
                    )
                    ->flatten();
                return $query->where(
                    fn($query) => $standards->map(
                        fn($standard) => $query->orWhereJsonContains(
                            "metadata->standards",
                            $standard,
                        ),
                    ),
                );
            })
            ->when(
                count($constraints["practices"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->practices",
                    $constraints["practices"],
                ),
            )
            ->when(
                count($constraints["languages"]) > 0,
                fn($query) => $query->whereJsonContains(
                    "metadata->languages",
                    $constraints["languages"],
                ),
            )
            ->when(
                count($constraints["categories"]) > 0,
                fn($query) => $query->whereIn(
                    "metadata->category",
                    $constraints["categories"],
                ),
            )
            ->when(
                count($constraints["audiences"]) > 0,
                fn($query) => $query->whereIn(
                    "metadata->audience",
                    $constraints["audiences"],
                ),
            )
            ->whereHas("likes", null, ">=", $constraints["likes_count"])
            ->whereHas("views", null, ">=", $constraints["views_count"]);
    }
}
