<?php

declare(strict_types=1);

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Search extends Model
{
    protected $fillable = ['user_id', 'search_params'];

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

    /**
     * @param  array<mixed>  $params
     * @return Collection<int, \Illuminate\Database\Eloquent\Model>
     *
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    public function search(array $params): Collection
    {
        $this->normalizeParams($params);
        /** @var array{type: Post|ContentCollection|Event, views: int, likes: int, metadata: array<string, list<string>>, q: string} $params */
        $this->search_params = $params;
        $this->save();

        // The following works, but because of how Laravel sets up typing, it fails PHPStan
        /** @phpstan-ignore-next-line */
        return $params['type']::query()
            ->search($params['q'])
            ->filterBy(Arr::except($params, ['type', 'q']))
            ->shouldBeSearchable()
            ->get();
    }

    /**
     * @param  array<mixed>  &$params
     * @return void
     *
     * @throws InvalidArgumentException
     *
     * @phpstan-assert array{type: Post|ContentCollection|Event, views: int, likes: int, metadata: array<string, list<string>>, q: string} $params
     */
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

    /**
     * @return array{search_params: 'array'}
     */
    protected function casts(): array
    {
        return [
            'search_params' => 'array',
        ];
    }
}
