<?php

namespace App\Processors\RiskRules;

class NoIncome extends RiskRuleHandler
{
    public function validate(): bool
    {
        return $this->userInformation->getIncome() === 0;
    }
}