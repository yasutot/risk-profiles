<?php

namespace App\Factories;

use App\Processors\RiskRules\RiskRuleHandler;

class RiskRuleHandlerFactory
{
    public static function createChain($rules): RiskRuleHandler
    {
        for ($index = 1; $index < count($rules); $index++) { 
            $rules[$index-1]->setNext($rules[$index]);
        }

        return $rules[0];
    }
}
