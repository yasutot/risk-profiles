<?php

namespace App\Processors\RiskRules;

class VehicleProducedAtLast5Years extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        $year = $this->userInformation->getVehicle()->getYear();

        return $year >= date('Y') - 5;
    }
}