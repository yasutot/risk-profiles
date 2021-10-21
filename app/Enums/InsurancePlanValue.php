<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self ECONOMIC()
 * @method static self REGULAR()
 * @method static self INELIGIBLE()
 * @method static self RESPONSIBLE()
 */
class InsurancePlanValue extends Enum
{
    private const ECONOMIC = 'economic';
    private const INELIGIBLE = 'ineligible';
    private const REGULAR = 'regular';
    private const RESPONSIBLE = 'responsible';
}
