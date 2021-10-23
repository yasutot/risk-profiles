<?php

namespace Tests\Unit\Models;

use App\Models\LifeInsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class LifeInsurancePlanTest extends TestCase
{
    public function testRiskRuleHandlerChain()
    {
        $userInformation = $this->createMock(UserInformation::class);
        $insurance = new LifeInsurancePlan($userInformation);

        $this->assertInstanceOf(RiskRuleHandler::class, $insurance->riskRuleHandlerChain());
    }
}
