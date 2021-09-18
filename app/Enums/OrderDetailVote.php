<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderDetailVote extends Enum
{
    const NOTVOTED = 1;
    const VOTED = 2;
}
