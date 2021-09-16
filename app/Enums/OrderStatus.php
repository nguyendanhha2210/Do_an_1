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
    const FAILURE = 4;
    const EVALUATED = 5;
}
