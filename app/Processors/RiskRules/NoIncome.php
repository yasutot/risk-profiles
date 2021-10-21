<?php

namespace App\Processors\RiskRules;

class NoIncome extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        return $this->userInformation->getIncome() === 0;
    }
}