<?php

namespace App\Processors\RiskRules;

use App\Enums\HouseOwnershipStatus;

class HouseIsMortgaged extends AbstractRiskRuleHandler
{
    public function validate(): bool
    {
        $status = $this->userInformation->getHouse()->getOwnershipStatus();

        return $status == HouseOwnershipStatus::MORTGAGED();
    }
}