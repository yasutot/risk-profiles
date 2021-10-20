<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self ADD()
 * @method static self SUBTRACT()
 * @method static self DENY()
 */
class Operation extends Enum
{
    private const ADD = 'add';
    private const SUBTRACT = 'subtract';
    private const DENY = 'deny';
}
