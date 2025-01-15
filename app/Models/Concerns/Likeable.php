<?php

namespace App\Models\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait Likeable
{
    /**
     * Get the likes count for the model.
     *
     * @return int
     */
    public function likes()
    {
        return Cache::remember("$this->id--likes_count", now()->addSeconds(30), function () {
            return DB::table('likes_log')
                ->where('model_type', self::class)
                ->where('model_id', $this->id)
                ->select('user_id')
                ->distinct()
                ->count(['user_id']);
        });
    }

    public function like()
    {
        DB::table('likes_log')->insert([
            'model_type' => self::class,
            'model_id' => $this->id,
            'user_id' => Auth::user()?->id ?? request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::forget("$this->id--likes_count");
    }

    protected function scopeOrderByLikes(Builder $query, $direction = 'desc')
    {
        return $query->orderBy(
            DB::table('likes_log')
                ->selectRaw('count(user_id)')
                ->whereColumn('model_id', $this->getTable().'.id')
                ->where('model_type', self::class),
            $direction
        );
    }

    protected function scopeHasLikesCount(Builder $query, $count)
    {
        return $query->where(
            DB::table('likes_log')
                ->whereColumn('model_id', $this->getTable().'.id')
                ->where('model_type', self::class)
                ->distinct()
                ->selectRaw('count(user_id) as likes_count'),
            '>=',
            $count
        );
    }
}
