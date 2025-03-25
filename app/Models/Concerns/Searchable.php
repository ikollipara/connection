<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
trait Searchable
{
    /** @use Likeable<T> */
    use Likeable;

    /** @use Viewable<T> */
    use Viewable;

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<T>  $query
     * @return \Illuminate\Database\Eloquent\Builder<T>
     */
    protected function scopeSearch(Builder $query, ?string $q)
    {
        $q ??= '';

        return $query->where(function (Builder $query) use ($q) {
            foreach ($this->getSearchableColumns() as $column) {
                $query->orWhereRaw("LOWER($column) LIKE LOWER(?)", ["%$q%"]);
            }
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<T>  $query
     * @param  array<string, mixed>  $params
     * @return \Illuminate\Database\Eloquent\Builder<T>
     */
    protected function scopeFilterBy(Builder $query, array $params)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    if (in_array($key.'->'.$k, $this->getFilterableColumns())) {
                        $query->whereJsonContains($key.'->'.$k, $v);
                    }
                }
            } elseif (in_array($key, $this->getFilterableColumns())) {
                $query->where($key, $value);
            }
        }

        // These lines assume the builder has implemented them.
        // TODO: Figure out how to type this.
        /** @phpstan-ignore-next-line */
        $query->HasViewsCount($params['views']);
        /** @phpstan-ignore-next-line */
        $query->HasLikesCount($params['likes']);

        return $query;
    }

    // @codeCoverageIgnoreStart
    // This is always overriden.
    /**
     * @param  \Illuminate\Database\Eloquent\Builder<T>  $query
     * @return \Illuminate\Database\Eloquent\Builder<T>
     */
    protected function scopeShouldBeSearchable(Builder $query): Builder
    {
        return $query;
    }
    // @codeCoverageIgnoreEnd

    /**
     * @return list<string>
     */
    protected function getSearchableColumns(): array
    {
        return $this->searchableColumns ?? [];
    }

    /**
     * @return list<string>
     */
    protected function getFilterableColumns(): array
    {
        return $this->filterableColumns ?? [];
    }
}
