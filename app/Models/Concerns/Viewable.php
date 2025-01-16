<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait Viewable
{
    /**
     * Get the views count for the model.
     *
     * @return int
     */
    public function views()
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

    public function view()
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

    protected function scopeOrderByViews($query, $direction = 'desc')
    {
        return $query->orderBySub(
            DB::table('views_log')
                ->selectRaw('count(user_id)')
                ->whereColumn('model_id', $this->getTable() . '.id')
                ->where('model_type', self::class),
            $direction
        );
    }

    protected function scopeHasViewsCount($query, $count)
    {
        return $query->where(
            DB::table('views_log')
                ->whereColumn('model_id', $this->getTable() . '.id')
                ->where('model_type', self::class)
                ->distinct()
                ->selectRaw('count(user_id) as views_count'),
            '>=',
            $count
        );
    }
}
