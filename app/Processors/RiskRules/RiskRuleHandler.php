<?php

namespace App\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;

abstract class RiskRuleHandler implements RiskRuleHandlerInterface
{
    protected ?RiskRuleHandlerInterface $nextHandler = null;
    protected UserInformation $userInformation;
    protected Operation $operation;

    public function __construct(UserInformation $userInformation, Operation $operation)
    {
        $this->userInformation = $userInformation;
        $this->operation = $operation;
    }

    public function setNext(RiskRuleHandlerInterface $handler): RiskRuleHandlerInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle($accumulator = 0)
    {
        if ($this->validate()) {
            $accumulator = $this->operation->execute($accumulator);
        }

        if ($this->nextHandler) {
            return $this->nextHandler->handle($accumulator);
        }

        return $accumulator;
    }

    public abstract function validate(): bool;
}
