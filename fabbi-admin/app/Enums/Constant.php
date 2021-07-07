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
    const STATUS_POSITIVE = 1;
    const STATUS_NEGATIVE = 0;
    const STATUS_QUARANTINE = 1;
    const STATUS_NOT_QUARANTINE = 0;
    const STATUS_OUT_QUARANTINE = -1;
    const NUMBER_CONDITION_POSITIVE = 3;
}
