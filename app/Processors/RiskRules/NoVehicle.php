<?php

namespace App\Processors\RiskRules;

class NoVehicle extends RiskRuleHandler
{
    public function validate(): bool
    {
        return $this->userInformation->getVehicle() === null;
    }
}