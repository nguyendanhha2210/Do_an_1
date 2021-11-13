<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SortByOption extends Enum
{
    const NEWS = 0;
    const PRICEINCREASE = 1;
    const REDUCEDPRICE = 2;
    const AToZ = 3;
    const ZToA = 4;

    public static function getDescription($value): string
    {
        if ($value === null) {
            return "Not Set";
        }

        switch ($value) {
            case self::NEWS:
                return '-- Mới nhất --';
                break;

            case self::PRICEINCREASE:
                return '-- Giá tăng dần --';
                break;

            case self::REDUCEDPRICE:
                return '-- Giá giảm dần --';
                break;

            case self::AToZ:
                return '-- Tên từ A -> Z --';
                break;

            case self::ZToA:
                return '-- Tên từ Z -> A --';
                break;
            default:
                return "Not Set";
                break;
        }
    }
}
