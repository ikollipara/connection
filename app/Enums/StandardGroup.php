<?php

/*|=============================================================================|
  | StandardGroup.php
  | Ian Kollipara <ikollipara2@huskers.unl.edu>
  |-----------------------------------------------------------------------------|
  | This file contains the StandardGroup class, which is an enumeration.
  |=============================================================================| */

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self CSTA_1A_CS()
 * @method static self CSTA_1B_CS()
 * @method static self CSTA_2_CS()
 * @method static self CSTA_3A_CS()
 * @method static self CSTA_3B_CS()
 * @method static self CSTA_1A_NI()
 * @method static self CSTA_1B_NI()
 * @method static self CSTA_2_NI()
 * @method static self CSTA_3A_NI()
 * @method static self CSTA_3B_NI()
 * @method static self CSTA_1A_DA()
 * @method static self CSTA_1B_DA()
 * @method static self CSTA_2_DA()
 * @method static self CSTA_3A_DA()
 * @method static self CSTA_3B_DA()
 * @method static self CSTA_1A_AP()
 * @method static self CSTA_1B_AP()
 * @method static self CSTA_2_AP()
 * @method static self CSTA_3A_AP()
 * @method static self CSTA_3B_AP()
 * @method static self CSTA_1A_IC()
 * @method static self CSTA_1B_IC()
 * @method static self CSTA_2_IC()
 * @method static self CSTA_3A_IC()
 * @method static self CSTA_3B_IC()
 * @method static self NE_CS_HS_1()
 * @method static self NE_CS_HS_2()
 * @method static self NE_CS_HS_3()
 * @method static self NE_CS_HS_4()
 * @method static self NE_CS_HS_5()
 * @method static self NE_CS_HS_6()
 */
class StandardGroup extends Enum
{
    protected static function labels()
    {
        return [
            'CSTA_1A_CS' => '1A-CS Computing Systems for K-2',
            'CSTA_1B_CS' => '1B-CS Computing Systems for 3-5',
            'CSTA_2_CS' => '2-CS Computing Systems for 6-8',
            'CSTA_3A_CS' => '3A-CS Computing Systems for 9-10',
            'CSTA_3B_CS' => '3B-CS Computing Systems for 11-12',
            'CSTA_1A_NI' => '1A-NI Networks & the Internet for K-2',
            'CSTA_1B_NI' => '1B-NI Networks & the Internet for 3-5',
            'CSTA_2_NI' => '2-NI Networks & the Internet for 6-8',
            'CSTA_3A_NI' => '3A-NI Networks & the Internet for 9-10',
            'CSTA_3B_NI' => '3B-NI Networks & the Internet for 11-12',
            'CSTA_1A_DA' => '1A-DA Data & Analysis for K-2',
            'CSTA_1B_DA' => '1B-DA Data & Analysis for 3-5',
            'CSTA_2_DA' => '2-DA Data & Analysis for 6-8',
            'CSTA_3A_DA' => '3A-DA Data & Analysis for 9-10',
            'CSTA_3B_DA' => '3B-DA Data & Analysis for 11-12',
            'CSTA_1A_AP' => '1A-AP Algorithms & Programming for K-2',
            'CSTA_1B_AP' => '1B-AP Algorithms & Programming for 3-5',
            'CSTA_2_AP' => '2-AP Algorithms & Programming for 6-8',
            'CSTA_3A_AP' => '3A-AP Algorithms & Programming for 9-10',
            'CSTA_3B_AP' => '3B-AP Algorithms & Programming for 11-12',
            'CSTA_1A_IC' => '1A-IC Impacts of Computing for K-2',
            'CSTA_1B_IC' => '1B-IC Impacts of Computing for 3-5',
            'CSTA_2_IC' => '2-IC Impacts of Computing for 6-8',
            'CSTA_3A_IC' => '3A-IC Impacts of Computing for 9-10',
            'CSTA_3B_IC' => '3B-IC Impacts of Computing for 11-12',
            'NE_CS_HS_1' => 'CS.HS.1 Demonstrate and describe best practices of computer literacy',
            'NE_CS_HS_2' => 'CS.HS.2 Analyze ethical practices and behaviors of digital citizenship',
            'NE_CS_HS_3' => 'CS.HS.3 Apply concepts of information technology',
            'NE_CS_HS_4' => 'CS.HS.4 Analyze the fundamentals of cybersecurity',
            'NE_CS_HS_5' => 'CS.HS.5 Apply concepts of computational thinking',
            'NE_CS_HS_6' => 'CS.HS.6 Implement programming literacy practices to create computational artifacts',
        ];
    }

    public static function values(): Closure
    {
        return function ($value) {
            if (str_starts_with($value, 'CSTA')) {
                return str_replace('_', '-', substr($value, 5));
            }
            if (str_starts_with($value, 'NE')) {
                return str_replace('_', '.', substr($value, 3));
            }
        };
    }
}
