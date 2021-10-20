<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self MARRIED()
 * @method static self SINGLE()
 */
class MaritalStatus extends Enum
{
    private const MARRIED = 'married';
    private const SINGLE = 'single';
}
