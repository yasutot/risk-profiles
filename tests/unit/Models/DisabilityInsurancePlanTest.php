<?php

namespace Tests\Unit\Models;

use App\Models\DisabilityInsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class DisabilityInsurancePlanTest extends TestCase
{
    public function testRiskRuleHandlerChain()
    {
        $userInformation = $this->createMock(UserInformation::class);
        $insurance = new DisabilityInsurancePlan($userInformation);

        $this->assertInstanceOf(RiskRuleHandler::class, $insurance->riskRuleHandlerChain());
    }
}
