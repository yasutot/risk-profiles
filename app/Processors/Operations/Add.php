<?php

namespace App\Processors\Operations;

class Add implements Operation
{
    public function execute($accumulator, $value): int
    {
        return $accumulator += $value;
    }
}
