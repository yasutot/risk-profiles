<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self OWNED()
 * @method static self MORTGAGED()
 */
class HouseOwnershipStatus extends Enum
{
    private const OWNED = 'owned';
    private const MORTGAGED = 'mortgaged';
}