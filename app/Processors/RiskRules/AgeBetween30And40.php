<?php

namespace App\Processors\RiskRules;

class AgeBetween30And40 extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        $age = $this->userInformation->getAge();

        return $age >= 30 && $age <= 40;
    }
}
