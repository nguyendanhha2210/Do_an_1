<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LimitNumber extends Enum
{
    const FIVE = 5;
    const TEN = 10;
    const TWENTY = 20;
    const THIRTY = 30;

    public static function getDescription($value): string
    {
        if ($value === null) {
            return "Not Set";
        }

        switch ($value) {
            case self::FIVE:
                return '-- 05 --';
                break;

            case self::TEN:
                return '-- 10 --';
                break;

            case self::TWENTY:
                return '-- 20 --';
                break;

            case self::THIRTY:
                return '-- 30 --';
                break;
            default:
                return "Not Set";
                break;
        }
    }
}
