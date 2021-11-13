<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WareHouserOption extends Enum
{
    const PERMITTED = 1;
    const ENTERED = 2;
    const EXCELIMPORT = 3;

    public static function getDescription($value): string
    {
        if ($value === null) {
            return "Not Set";
        }

        switch ($value) {
            case self::PERMITTED:
                return '-- Permitted goods --';
                break;

            case self::ENTERED:
                return '-- Entered --';
                break;

            case self::EXCELIMPORT:
                return '-- Excel Import --';
                break;
            default:
                return "Not Set";
                break;
        }
    }
}
