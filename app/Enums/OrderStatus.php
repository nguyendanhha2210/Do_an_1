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
    const SUCCESS  = 3;
    const EVALUATED = 4;
    const FAILURE = 5;
    const RETURNS = 6;
}
