<?php

namespace App\Processors\RiskRules;

class NoHouse extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        return $this->userInformation->getHouse() === null;
    }
}