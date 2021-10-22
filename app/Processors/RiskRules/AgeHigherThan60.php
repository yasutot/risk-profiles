<?php

namespace App\Processors\RiskRules;

class AgeHigherThan60 extends RiskRuleHandler
{
    public function validate(): bool
    {
        $age = $this->userInformation->getAge();

        return $age > 60;
    }
}
