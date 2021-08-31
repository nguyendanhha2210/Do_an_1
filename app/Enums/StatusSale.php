<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusSale extends Enum
{
    const UP = 0;
    const DOWN = 1;
    const JUSTENTERD = 2;
}
