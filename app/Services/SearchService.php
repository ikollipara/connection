<?php

/*|=============================================================================|
  | SearchService.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the SearchService class. This class is responsible for
  | handling the search functionality of the application.
  |=============================================================================| */

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

/**
 * |=============================================================================|
 * | SearchService
 * |-----------------------------------------------------------------------------|
 * | This class is responsible for handling the search functionality of the
 * | application. It wraps the perticularities of the search functionality in
 * | a single class.
 * |=============================================================================| */
class SearchService
{
    protected string $model;

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * Search for content based on the given constraints.
     * @param array $constraints The constraints to search by
     * @return Collection<\App\Contracts\IsSearchable> The content that matches the constraints
     */
    public function search(
        array $constraints,
        string $query_key = "q"
    ): Collection {
        $constraints = $this->model::normalizeSearchConstraints($constraints);
        return $this->model::search(trim($constraints[$query_key]))
            ->query(fn ($query) => $query->withSearchConstraints($constraints))
            ->get();
    }
}
