<?php

namespace App\Enums;

use Closure;
use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self students()
 * @method static self teachers()
 */
class Audience extends Enum
{
    protected static function labels(): Closure
    {
        return fn(string $value) => Str::of($value)->title()->plural()->__toString();
    }
}
