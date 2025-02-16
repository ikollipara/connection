<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

/**
 * @template T of Model
 */
class OrderByLikes implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder<T>  $builder
     * @param  T  $model
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
