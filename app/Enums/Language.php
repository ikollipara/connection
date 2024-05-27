<?php

namespace App\Enums;

use Closure;
use Illuminate\Support\Str;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self blockly()
 * @method static self c()
 * @method static self cpp()
 * @method static self csharp()
 * @method static self css()
 * @method static self go()
 * @method static self html()
 * @method static self java()
 * @method static self javascript()
 * @method static self kotlin()
 * @method static self lua()
 * @method static self php()
 * @method static self python()
 * @method static self ruby()
 * @method static self scratch()
 * @method static self sql()
 * @method static self swift()
 * @method static self typescript()
 */
class Language extends Enum
{
    protected static function labels(): Closure
    {
        return function(string $value) {
            if($value === 'javascript') {
                return 'JavaScript';
            } elseif($value === 'csharp') {
                return 'C#';
            } elseif($value === 'cpp') {
                return 'C++';
            } elseif($value === 'typescript') {
                return 'TypeScript';
            } elseif($value === 'sql') {
                return 'SQL';
            } else {
                return Str::of($value)->title()->__toString();
            }
        };
    }
}
