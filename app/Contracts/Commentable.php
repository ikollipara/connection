<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Commentable
{
    /**
     * Get all of the comments for the model.
     *
     * @return MorphMany<\App\Models\Comment, \Illuminate\Database\Eloquent\Model & self>
     */
    public function comments(): MorphMany;
}
