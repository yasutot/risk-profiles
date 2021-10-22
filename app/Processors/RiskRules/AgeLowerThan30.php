<?php

namespace App\Processors\RiskRules;

class AgeLowerThan30 extends RiskRuleHandler
{
    public function validate(): bool
    {
        $age = $this->userInformation->getAge();

        return $age < 30;
    }
}