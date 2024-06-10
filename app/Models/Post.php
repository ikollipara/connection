<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * App\Models\Post
 */
class Post extends Content implements Commentable
{
    use HasFactory, HasParent, HasComments;
}
