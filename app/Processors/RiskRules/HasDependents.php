<?php

namespace App\Processors\RiskRules;

class HasDependents extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        $dependents = $this->userInformation->getDependents();

        return (bool) $dependents;
    }
}