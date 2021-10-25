<?php

namespace App\Factories;

use App\Processors\RiskRules\RiskRuleHandler;

class RiskRuleHandlerFactory
{
    public static function createChain($rules): RiskRuleHandler
    {
        $firstRule = array_shift($rules);

        return array_reduce($rules, function($chain, $rule) {
            $chain->setNext($rule);
            return $chain;
        }, $firstRule);
    }
}
