<?php

namespace App\Processors\Operations;

Interface OperationInterface
{
    public function execute($accumulator): int;
}