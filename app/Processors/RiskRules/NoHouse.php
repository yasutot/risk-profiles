<?php

namespace App\Processors\RiskRules;

class NoHouse extends RiskRuleHandler
{
    public function validate(): bool
    {
        return $this->userInformation->getHouse() === null;
    }
}