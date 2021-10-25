<?php

namespace Test\Processors\Operations;

use App\Processors\Operations\Subtract;
use TestCase;

class SubtractTest extends TestCase
{
    public function testExecute()
    {
        $accumulator = rand(1, 10);
        $value = rand(1, 10);

        $operation = new Subtract($value);

        $this->assertEquals($accumulator - $value, $operation->execute($accumulator));
    }
}