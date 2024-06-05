<?php

namespace App\Http\Livewire;

use App\Enums\Standard;
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
            ->query(fn($query) => $query->applySearchConstraints($constraints))
            ->get()
            ->toArray();

        // $post_query = Post::search($this->query)->query(function (
        //     Builder $query
        // ) use (
        //     $grades_count,
        //     $standards_count,
        //     $practices_count,
        //     $languages_count,
        //     $categories_count,
        //     $audiences_count,
        //     $standard_groups_count
        // ) {
        //     return $query
        //         ->where("published", true)
        //         ->when(
        //             $grades_count > 0,
        //             fn($query) => $query->whereJsonContains(
        //                 "metadata->grades",
        //                 $this->grades,
        //             ),
        //         )
        //         ->when(
        //             $standards_count > 0,
        //             fn($query) => $query->whereJsonContains(
        //                 "metadata->standards",
        //                 $this->standards,
        //             ),
        //         )
        //         ->when($standard_groups_count > 0, function ($query) {
        //             $standards = collect($this->standard_groups)
        //                 ->map(fn($group) => Standard::getGroup($group))
        //                 ->flatten();
        //             return $query->where(
        //                 fn($query) => $standards->map(
        //                     fn($standard) => $query->orWhereJsonContains(
        //                         "metadata->standards",
        //                         $standard,
        //                     ),
        //                 ),
        //             );
        //         })
        //         ->when(
        //             $practices_count > 0,
        //             fn($query) => $query->whereJsonContains(
        //                 "metadata->practices",
        //                 $this->practices,
        //             ),
        //         )
        //         ->when(
        //             $languages_count > 0,
        //             fn($query) => $query->whereJsonContains(
        //                 "metadata->languages",
        //                 $this->languages,
        //             ),
        //         )
        //         ->when(
        //             $categories_count > 0,
        //             fn($query) => $query->whereIn(
        //                 "metadata->category",
        //                 $this->categories,
        //             ),
        //         )
        //         ->when(
        //             $audiences_count > 0,
        //             fn($query) => $query->whereIn(
        //                 "metadata->audience",
        //                 $this->audiences,
        //             ),
        //         )
        //         ->when(
        //             $this->likes_count != 0,
        //             fn($query) => $query->where(
        //                 "likes_count",
        //                 ">=",
        //                 $this->likes_count,
        //             ),
        //         )
        //         ->when(
        //             $this->views_count != 0,
        //             fn($query) => $query->where(
        //                 "views",
        //                 ">=",
        //                 $this->views_count,
        //             ),
        //         )
        //         ->orderBy("likes_count", "desc")
        //         ->orderBy("views", "desc");
        // });
        // $collection_query = PostCollection::search($this->query)->query(
        //     function (Builder $query) use (
        //         $grades_count,
        //         $standards_count,
        //         $practices_count,
        //         $languages_count,
        //         $categories_count,
        //         $audiences_count
        //     ) {
        //         return $query
        //             ->where("published", true)
        //             ->withCount("posts")
        //             ->when(
        //                 $grades_count > 0,
        //                 fn($query) => $query->whereJsonContains(
        //                     "metadata->grades",
        //                     $this->grades,
        //                 ),
        //             )
        //             ->when(
        //                 $standards_count > 0,
        //                 fn($query) => $query->whereJsonContains(
        //                     "metadata->standards",
        //                     $this->standards,
        //                 ),
        //             )
        //             ->when(
        //                 $practices_count > 0,
        //                 fn($query) => $query->whereJsonContains(
        //                     "metadata->practices",
        //                     $this->practices,
        //                 ),
        //             )
        //             ->when(
        //                 $languages_count > 0,
        //                 fn($query) => $query->whereJsonContains(
        //                     "metadata->languages",
        //                     $this->languages,
        //                 ),
        //             )
        //             ->when(
        //                 $categories_count > 0,
        //                 fn($query) => $query->whereIn(
        //                     "metadata->category",
        //                     $this->categories,
        //                 ),
        //             )
        //             ->when(
        //                 $audiences_count > 0,
        //                 fn($query) => $query->whereIn(
        //                     "metadata->audience",
        //                     $this->audiences,
        //                 ),
        //             )
        //             ->when(
        //                 $this->likes_count != 0,
        //                 fn($query) => $query->where(
        //                     "likes_count",
        //                     ">=",
        //                     $this->likes_count,
        //                 ),
        //             )
        //             ->when(
        //                 $this->views_count != 0,
        //                 fn($query) => $query->where(
        //                     "views",
        //                     ">=",
        //                     $this->views_count,
        //                 ),
        //             )
        //             ->orderBy("likes_count", "desc")
        //             ->orderBy("views", "desc");
        //     },
        // );
        // if ($this->type === "post") {
        //     $this->post_results = $post_query
        //         ->query(fn(Builder $query) => $query->with("user"))
        //         ->get();
        // } elseif ($this->type === "collection") {
        //     $this->collection_results = $collection_query
        //         ->query(fn(Builder $query) => $query->with("user"))
        //         ->get();
        // } else {
        //     $this->post_results = $post_query->get();
        //     $this->collection_results = $collection_query->get();
        // }
        // $this->results = collect(
        //     array_merge(
        //         $this->post_results->all(),
        //         $this->collection_results->all(),
        //     ),
        // )->sortBy([["likes_count", "desc"], ["views", "desc"]]);
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
}
