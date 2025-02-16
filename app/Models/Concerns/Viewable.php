<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * @template T of Model
 */
trait Viewable
{
    /**
     * Get the views count for the model.
     */
    public function views(): int
    {
        return Cache::remember("$this->id--views_count", now()->addSeconds(30), function () {
            return DB::table('views_log')
                ->where('model_type', self::class)
                ->where('model_id', $this->id)
                ->select('user_id')
                ->distinct()
                ->count('user_id');
        });
    }

    public function view(): void
    {
        DB::table('views_log')->insert([
            'model_type' => self::class,
            'model_id' => $this->id,
            'user_id' => Auth::user()->id ?? request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::forget("$this->id--views_count");
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<T>  $query
     * @param  'asc'|'desc'  $direction
     * @return \Illuminate\Database\Eloquent\Builder<T>
     *
     * @throws InvalidArgumentException
     */
    protected function scopeOrderByViews($query, $direction = 'desc')
    {
        return $query->orderBy(
            DB::table('views_log')
                ->selectRaw('count(user_id)')
                ->whereColumn('model_id', $this->getTable().'.id')
                ->where('model_type', self::class),
            $direction
        );
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<T>  $query
     * @param  0|positive-int  $count
     * @return \Illuminate\Database\Eloquent\Builder<T>
     */
    protected function scopeHasViewsCount($query, $count)
    {
        return $query->where(
            /** @phpstan-ignore-next-line */
            DB::table('views_log')
                ->whereColumn('model_id', $this->getTable().'.id')
                ->where('model_type', self::class)
                ->distinct()
                ->selectRaw('count(user_id) as views_count'),
            '>=',
            $count
        );
    }
}
