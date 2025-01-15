<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * \App\Models\Entry
 *
 * @property int $id
 * @property string $content_id
 * @property string $collection_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Content $content
 * @property \App\Models\ContentCollection $collection
 */
class Entry extends Model
{
    use AsPivot, HasFactory;

    protected $table = 'entries';

    public $timestamps = true;

    public $incrementing = true;

    protected $fillable = ['content_id', 'collection_id'];

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    /**
     * Get the content that the entry belongs to.
     *
     * @return BelongsTo<Content, covariant self>
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the collection that the entry belongs to.
     *
     * @return BelongsTo<ContentCollection, covariant self>
     */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(ContentCollection::class);
    }
}
