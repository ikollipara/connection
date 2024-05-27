<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self kindergarten()
 * @method static self first()
 * @method static self second()
 * @method static self third()
 * @method static self fourth()
 * @method static self fifth()
 * @method static self sixth()
 * @method static self seventh()
 * @method static self eighth()
 * @method static self ninth()
 * @method static self tenth()
 * @method static self eleventh()
 * @method static self twelfth()
 */
class Grade extends Enum
{
    protected static function values()
    {
        return [
            'kindergarten' => 'K',
            'first' => 1,
            'second' => 2,
            'third' => 3,
            'fourth' => 4,
            'fifth' => 5,
            'sixth' => 6,
            'seventh' => 7,
            'eighth' => 8,
            'ninth' => 9,
            'tenth' => 10,
            'eleventh' => 11,
            'twelfth' => 12,
        ];
    }

    protected static function labels()
    {
        return [
            'kindergarten' => 'Kindergarten',
            'first' => '1st',
            'second' => '2nd',
            'third' => '3rd',
            'fourth' => '4th',
            'fifth' => '5th',
            'sixth' => '6th',
            'seventh' => '7th',
            'eighth' => '8th',
            'ninth' => '9th',
            'tenth' => '10th',
            'eleventh' => '11th',
            'twelfth' => '12th',
        ];
    }
}
