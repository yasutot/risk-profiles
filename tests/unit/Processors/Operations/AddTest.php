<?php

namespace Test\Processors\Operations;

use App\Processors\Operations\Add;
use TestCase;

class AddTest extends TestCase
{
    public function testExecute()
    {
        $accumulator = rand(1, 10);
        $value = rand(1, 10);

        $operation = new Add($value);

        $this->assertEquals($accumulator + $value, $operation->execute($accumulator));
    }
}