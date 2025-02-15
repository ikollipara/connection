<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
trait Likeable
{
    /**
     * Get the likes count for the model.
     */
    public function likes(): int
    {
        return Cache::remember("$this->id--likes_count", now()->addSeconds(30), function () {
            return DB::table('likes_log')
                ->where('model_type', self::class)
                ->where('model_id', $this->id)
                ->select('user_id')
                ->distinct()
                ->count('user_id');
        });
    }

    public function like(): void
    {
        DB::table('likes_log')->insert([
            'model_type' => self::class,
            'model_id' => $this->id,
            'user_id' => Auth::user()->id ?? request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::forget("$this->id--likes_count");
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder<T> $query
     * @param 'asc'|'desc' $direction
     * @return \Illuminate\Database\Eloquent\Builder<T>
     * @throws \InvalidArgumentException
     */
    protected function scopeOrderByLikes(Builder $query, $direction = 'desc')
    {

        $model = $query->getModel();
        $model_type = $model::class;

        return $query->orderBy(
            DB::table('likes_log')
                ->selectRaw('count(user_id)')
                ->whereColumn('model_id', $this->getTable() . '.id')
                ->where('model_type', $model_type),
            $direction
        );
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder<T> $query
     * @param 0|positive-int $count
     * @return \Illuminate\Database\Eloquent\Builder<T>
     * @throws \InvalidArgumentException
     */
    protected function scopeHasLikesCount(Builder $query, $count)
    {
        $model = $query->getModel();
        $model_type = $model::class;

        return $query->where(
            // @phpstan-ignore-next-line
            DB::table('likes_log')
                ->whereColumn('model_id', $this->getTable() . '.id')
                ->where('model_type', $model_type)
                ->distinct()
                ->selectRaw('count(user_id) as likes_count'),
            '>=',
            $count
        );
    }
}
