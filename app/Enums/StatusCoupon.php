<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusCoupon extends Enum
{
    const SEND = 1; //Send for customer
    const SHOW = 2; //Show for customer
    const UNSAVED = 3; //người dùng dc gửi đến màn chi tiết sp
    const SAVE = 4; //người dùng lưu để sử dụng
}
