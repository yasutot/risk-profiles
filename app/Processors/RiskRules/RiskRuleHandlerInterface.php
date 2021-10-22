<?php

namespace App\Processors\RiskRules;

interface RiskRuleHandlerInterface
{
    public function setNext(RiskRuleHandlerInterface $handler): RiskRuleHandlerInterface;
    public function handle($accumulator = 0);
}
