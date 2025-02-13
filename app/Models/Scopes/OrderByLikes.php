<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class OrderByLikes implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy(
            DB::table('likes_log')
                ->selectRaw('count(user_id)')
                ->whereColumn('model_id', $model->getTable().'.id')
                ->where('model_type', $model::class),
            'desc'
        );

    }
}
