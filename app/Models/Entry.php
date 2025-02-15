<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

class Entry extends Model
{
    use AsPivot;
    /** @use HasFactory<\Database\Factories\EntryFactory> */
    use HasFactory;

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
     * @return BelongsTo<Content, $this>
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the collection that the entry belongs to.
     *
     * @return BelongsTo<ContentCollection, $this>
     */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(ContentCollection::class);
    }
}
