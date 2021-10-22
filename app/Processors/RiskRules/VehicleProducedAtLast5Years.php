<?php

namespace App\Processors\RiskRules;

class VehicleProducedAtLast5Years extends RiskRuleHandler
{
    public function validate(): bool
    {
        $vehicle = $this->userInformation->getVehicle();

        if ($vehicle) {
            return $vehicle->getYear() >= date('Y') - 5;
        }

        return false;
    }
}