<?php

namespace App\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;

abstract class RiskRuleHandler implements RiskRuleHandlerInterface
{
    protected ?RiskRuleHandlerInterface $nextHandler = null;
    protected UserInformation $userInformation;
    protected Operation $operation;
    protected int $value;

    public function __construct(UserInformation $userInformation, Operation $operation, int $value)
    {
        $this->userInformation = $userInformation;
        $this->operation = $operation;
        $this->value = $value;
    }

    public function setNext(RiskRuleHandlerInterface $handler): RiskRuleHandlerInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle($accumulator = 0)
    {
        if ($this->validate()) {
            $accumulator = $this->operation->execute($accumulator, $this->value);
        }

        if ($this->nextHandler) {
            return $this->nextHandler->handle($accumulator);
        }

        return $accumulator;
    }

    public abstract function validate(): bool;
}
