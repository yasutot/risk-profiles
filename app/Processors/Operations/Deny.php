<?php

namespace App\Processors\Operations;

use App\Exceptions\IneligibleInsurancePlanException;

class Deny implements Operation
{
    public function execute($accumulator, $value): int
    {
        throw new IneligibleInsurancePlanException();
    }
}
