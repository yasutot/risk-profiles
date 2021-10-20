<?php

namespace App\Processors\RiskRules;

interface RiskRuleHandler
{
    public function setNext(RiskRuleHandler $handler): RiskRuleHandler;
    public function handle($accumulator = 0);
}
