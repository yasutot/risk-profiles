<?php

namespace App\Processors\Operations;

class Subtract extends Operation
{
    public function execute($accumulator): int
    {
        return $accumulator -= $this->value;
    }
}
