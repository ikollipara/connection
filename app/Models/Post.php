<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

/**
 * App\Models\Post
 */
class Post extends Content
{
    use HasFactory, HasParent;
}
