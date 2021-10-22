<?php

namespace App\Processors\RiskRules;

use App\Enums\MaritalStatus;

class IsMarried extends RiskRuleHandler
{
    public function validate(): bool
    {
        $status = $this->userInformation->getMaritalStatus();

        return $status == MaritalStatus::MARRIED();
    }
}