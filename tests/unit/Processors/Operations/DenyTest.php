<?php

namespace Test\Processors\Operations;

use App\Exceptions\IneligibleInsurancePlanException;
use App\Processors\Operations\Deny;
use TestCase;

class DenyTest extends TestCase
{
    public function testExecute()
    {
        $accumulator = rand(1, 10);
        $value = rand(1, 10);

        $operation = new Deny($value);

        $this->expectException(IneligibleInsurancePlanException::class);

        $operation->execute($accumulator);
    }
}