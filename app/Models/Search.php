<?php

declare(strict_types=1);

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * @property int $id
 * @property string $user_id
 * @property array $search_params
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \App\Models\User $user
 */
class Search extends Model
{
    protected $fillable = ['user_id', 'search_params'];

    protected $casts = [
        'search_params' => 'array',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function (Search $search) {
            $search->user_id = $search->user_id ?? (Auth::user()->id ?? request()->ip());
        });
    }

    public function search(array $params): Collection
    {
        $this->normalizeParams($params);

        $this->search_params = $params;
        $this->save();

        return $params['type']::query()
            ->search($params['q'])
            ->filterBy(Arr::except($params, ['type', 'q']))
            ->shouldBeSearchable()
            ->get();
    }

    private function normalizeParams(array &$params)
    {
        data_fill($params, 'views', 0);
        data_fill($params, 'likes', 0);
        data_fill($params, 'audiences', []);
        data_fill($params, 'categories', []);
        data_fill($params, 'standards', []);
        data_fill($params, 'practices', []);
        data_fill($params, 'languages', []);
        data_fill($params, 'grades', []);
        data_fill($params, 'q', '');

        data_set($params, 'metadata', [
            'audiences' => $params['audiences'],
            'categories' => $params['categories'],
            'standards' => $params['standards'],
            'practices' => $params['practices'],
            'languages' => $params['languages'],
            'grades' => $params['grades'],
        ]);
        data_forget($params, ['audiences', 'categories', 'standards', 'practices', 'languages', 'grades']);

        match ($params['type']) {
            'post' => $params['type'] = Post::class,
            'collection' => $params['type'] = ContentCollection::class,
            'event' => $params['type'] = Event::class,
            default => throw new InvalidArgumentException("type is invalid: {$params['type']}"),
        };
    }
}
