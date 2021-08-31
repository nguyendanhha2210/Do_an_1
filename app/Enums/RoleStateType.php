<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleStateType extends Enum
{
    const MANAGERMENT = 1;
    const SALER = 2;
    const SHIP = 3;
}
