<?php

namespace Tests\Unit\Models;

use App\Models\AutoInsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class AutoInsurancePlanTest extends TestCase
{
    public function testRiskRuleHandlerChain()
    {
        $userInformation = $this->createMock(UserInformation::class);
        $insurance = new AutoInsurancePlan($userInformation);

        $riskRules = $insurance->riskRules();

        foreach ($riskRules as $riskRule) {
            $this->assertInstanceOf(RiskRuleHandler::class, $riskRule);
        }
    }
}
