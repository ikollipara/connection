<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self material()
 * @method static self activity()
 * @method static self lesson()
 * @method static self theory()
 * @method static self assignment()
 * @method static self assessment()
 * @method static self plan()
 */
class Category extends Enum
{
    protected static function labels(): Closure
    {
        return fn (string $value) => ucfirst($value);
    }
}
