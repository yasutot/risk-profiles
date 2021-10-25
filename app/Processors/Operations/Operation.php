<?php

namespace App\Processors\Operations;


abstract class Operation implements OperationInterface
{
    protected ?int $value = null;

    public function __construct(?int $value = null)
    {
        $this->value = $value;
    }

    public abstract function execute($accumulator): int;
}