<?php

namespace App\Processors\RiskRules;

use App\Enums\Operation;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Exceptions\RiskRuleException;
use App\Models\UserInformation;

abstract class AbstractRiskRuleHandler implements RiskRuleHandler
{
    protected ?RiskRuleHandler $nextHandler;
    protected UserInformation $userInformation;
    protected Operation $operation;
    protected int $value;

    public function __construct(UserInformation $userInformation, Operation $operation, int $value)
    {
        $this->userInformation = $userInformation;
        $this->operation = $operation;
        $this->value = $value;
    }

    public function setNext(RiskRuleHandler $handler): RiskRuleHandler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle($accumulator = 0)
    {
        if ($this->validate($accumulator)) {
            $accumulator = $this->executeOperation($accumulator);
        }

        if ($this->nextHandler) {
            return $this->nextHandler->handle($accumulator);
        }

        return $accumulator;
    }

    public abstract function validate(): bool;

    public function executeOperation($accumulator)
    {
        switch ($this->operation) {
            case Operation::ADD():
                return $this->addToAccumulator($accumulator);
            case Operation::SUBTRACT():
                return $this->subtractFromAccumulator($accumulator);
            case Operation::DENY():
                return $this->deny();
            default:
                throw new RiskRuleException('Operation not found.');
        }
    }

    public function addToAccumulator($accumulator)
    {
        return $accumulator += $this->value;
    }

    public function subtractFromAccumulator($accumulator)
    {
        return $accumulator -= $this->value;
    }

    public function deny()
    {
        throw new IneligibleInsurancePlanException();
    }
}
