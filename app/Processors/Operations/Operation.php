<?php

namespace App\Processors\Operations;

Interface Operation
{
    public function execute($accumulator, $value): int;
}