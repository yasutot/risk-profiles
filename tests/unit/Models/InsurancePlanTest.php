<?php

namespace Tests\Unit\Models;

use App\Enums\Operation;
use App\Models\AutoInsurancePlan;
use App\Models\DisabilityInsurancePlan;
use App\Models\HomeInsurancePlan;
use App\Models\LifeInsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\AbstractRiskRuleHandler;
use TestCase;

class InsurancePlanTest extends TestCase
{
    public function test_rules()
    {
        $insurancePlans = [
            AutoInsurancePlan::class,
            DisabilityInsurancePlan::class,
            HomeInsurancePlan::class,
            LifeInsurancePlan::class
        ];

        foreach ($insurancePlans as $insurancePlan) {
            $ui = $this->createMock(UserInformation::class);
            $insurancePlan = new $insurancePlan($ui);
            $rules = $this->getProtectedPropertyValue($insurancePlan, 'rules');

            $this->assertNotEmpty($rules);

            foreach ($rules as $rule) {
                $this->assertCount(3, $rule);
                $this->assertTrue(is_subclass_of($rule[0], AbstractRiskRuleHandler::class, true));
                $this->assertTrue(Operation::isValid($rule[1]));
                $this->assertIsInt($rule[2]);
            }
        }
    }
}
