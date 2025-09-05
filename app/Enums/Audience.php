<?php

declare(strict_types=1);

namespace App\Enums;

use Closure;
use App\Attributes\Legacy;
use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self students()
 * @method static self teachers()
 */
#[Legacy("This is no longer used.")]
class Audience extends Enum
{
    protected static function labels(): Closure
    {
        return fn (string $value) => Str::of($value)->title()->plural()->__toString();
    }
}
