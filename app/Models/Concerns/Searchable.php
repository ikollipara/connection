<?php

namespace App\Models\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait Searchable
{
    use Likeable, Viewable;

    protected function scopeSearch(Builder $query, ?string $q)
    {
        $q ??= '';
        return $query->where(function (Builder $query) use ($q) {
            foreach ($this->getSearchableColumns() as $column) {
                $query->orWhereRaw("LOWER($column) LIKE LOWER(?)", ["%$q%"]);
            }
        });
    }

    protected function scopeFilterBy(Builder $query, array $params)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach($value as $k => $v) {
                    if(in_array($key."->".$k, $this->getFilterableColumns())) {
                        $query->whereJsonContains($key."->".$k, $v);
                    }
                }
            }
            elseif (in_array($key, $this->getFilterableColumns())) {
                $query->where($key, $value);
            }
        }

        $query->HasViewsCount($params['views']);
        $query->HasLikesCount($params['likes']);

        return $query;
    }

    protected function scopeShouldBeSearchable($query)
    {
        return $query;
    }

    protected function getSearchableColumns(): array
    {
        return $this->searchableColumns ?? [];
    }

    protected function getFilterableColumns(): array
    {
        return $this->filterableColumns ?? [];
    }
}
