<?php

namespace App\Processors\RiskRules;

class IncomeHigherThan200K extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        $income = $this->userInformation->getIncome();

        return $income > 200000;
    }
}