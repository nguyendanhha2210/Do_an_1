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
    const NEW = 0;
    const PRICEINCREASE = 1;
    const REDUCEDPRICE = 2;
    const AToZ = 3;
    const ZToA = 4;
}