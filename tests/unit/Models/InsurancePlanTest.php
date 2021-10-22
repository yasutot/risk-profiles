<?php

namespace Tests\Unit\Models;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class InsurancePlanTest extends TestCase
{
    /**
     * @testWith
     *      ["App\\Models\\AutoInsurancePlan"]
     *      ["App\\Models\\DisabilityInsurancePlan"]
     *      ["App\\Models\\HomeInsurancePlan"]
     *      ["App\\Models\\LifeInsurancePlan"]
     */
    public function testRules($insurancePlan)
    {
        $ui = $this->createMock(UserInformation::class);
        $insurancePlan = new $insurancePlan($ui);
        $rules = $this->getProtectedPropertyValue($insurancePlan, 'rules');

        $this->assertNotEmpty($rules);

        foreach ($rules as $rule) {
            $this->assertCount(3, $rule);
            $this->assertTrue(is_subclass_of($rule['rule'], RiskRuleHandler::class, true));
            $this->assertTrue(is_subclass_of($rule['operation'], Operation::class));
            $this->assertIsInt($rule['score']);
        }
    }
}
