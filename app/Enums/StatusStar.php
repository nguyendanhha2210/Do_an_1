<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusStar extends Enum
{
    const ONESTAR = 1;
    const TWOSTARS = 2;
    const THREESTARS = 3;
    const FOURSTARS = 4;
    const FIVESTARS = 5;
}
