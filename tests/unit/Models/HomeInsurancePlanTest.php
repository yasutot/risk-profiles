<?php

namespace Tests\Unit\Models;

use App\Models\HomeInsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class HomeInsurancePlanTest extends TestCase
{
    public function testRiskRuleHandlerChain()
    {
        $userInformation = $this->createMock(UserInformation::class);
        $insurance = new HomeInsurancePlan($userInformation);

        $riskRules = $insurance->riskRules();

        foreach ($riskRules as $riskRule) {
            $this->assertInstanceOf(RiskRuleHandler::class, $riskRule);
        }
    }
}
