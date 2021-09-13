<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CommentRank extends Enum
{
    const FIRSTRANK = 1;
    const SECONDRANK = 2;
}
