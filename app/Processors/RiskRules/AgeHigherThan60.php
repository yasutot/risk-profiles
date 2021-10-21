<?php

namespace App\Processors\RiskRules;

class AgeHigherThan60 extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        $age = $this->userInformation->getAge();

        return $age > 60;
    }
}
