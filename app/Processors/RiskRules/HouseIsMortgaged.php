<?php

namespace App\Processors\RiskRules;

use App\Enums\HouseOwnershipStatus;

class HouseIsMortgaged extends RiskRuleHandler
{
    public function validate(): bool
    {
        $house = $this->userInformation->getHouse();

        if($house) {
            return $house->getOwnershipStatus() == HouseOwnershipStatus::MORTGAGED();
        }

        return false;
    }
}