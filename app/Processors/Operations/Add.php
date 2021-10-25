<?php

namespace App\Processors\Operations;

class Add extends Operation
{
    public function execute($accumulator): int
    {
        return $accumulator += $this->value;
    }
}
