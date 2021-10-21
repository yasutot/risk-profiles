<?php

namespace App\Processors\RiskRules;

class NoVehicle extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        return $this->userInformation->getVehicle() === null;
    }
}