<?php

namespace App\Processors\Operations;

class Subtract implements Operation
{
    public function execute($accumulator, $value): int
    {
        return $accumulator -= $value;
    }
}
