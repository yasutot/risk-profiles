<?php

namespace App\Processors\Operations;

use App\Exceptions\IneligibleInsurancePlanException;

class Deny extends Operation
{
    public function execute($accumulator): int
    {
        throw new IneligibleInsurancePlanException();
    }
}
