<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ITEM_PER_PAGE()
 */
final class Constant extends Enum
{
    const ITEM_PER_PAGE = 5;
    const  STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;
}
