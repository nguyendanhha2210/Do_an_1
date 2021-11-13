<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const ORDER = 1;
    const SHIPPING = 2;
    const SUCCESS = 3;
    const EVALUATED = 4;
    const FAILURE = 5;
    const RETURNS = 6;

    public static function getDescription($value): string
    {
        if ($value === null) {
            return "Not Set";
        }

        switch ($value) {
            case self::ORDER:
                return '-- Ordered --';
                break;

            case self::SHIPPING:
                return '-- Shipping --';
                break;

            case self::SUCCESS:
                return '-- Success --';
                break;

            case self::EVALUATED:
                return '-- Evaluated --';
                break;
            case self::FAILURE:
                return '-- Failure --';
                break;

            case self::RETURNS:
                return '-- Return --';
                break;
            default:
                return "Not Set";
                break;
        }
    }
}
