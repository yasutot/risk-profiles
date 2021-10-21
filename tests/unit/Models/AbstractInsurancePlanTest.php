<?php

namespace Tests\Unit\Models;

use App\Models\AbstractInsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\AbstractRiskRuleHandler;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class StubInsurancePlan extends AbstractInsurancePlan {}
class StubRiskRule extends AbstractRiskRuleHandler {
    public function validate(): bool
    {
        return false;
    }
}

class AbstractInsurancePlanTest extends TestCase
{
    public function test_construct_sets_user_information()
    {
        $ui = $this->createMock(UserInformation::class);
        $insurancePlan = new StubInsurancePlan($ui);
        $insurancePlanUserInformation = $this->getProtectedPropertyValue($insurancePlan, 'userInformation');

        $this->assertEquals($ui, $insurancePlanUserInformation);
    }

    public function test_base_value()
    {
        $dataSet = [
            [[1,1,1], 3],
            [[1,2,3], 6],
            [[0,1,0], 1]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getRiskQuestions')->will($this->returnValue($data[0]));

            $insurancePlan = new StubInsurancePlan($ui);
            $insurancePlanReflection = $this->getReflection(StubInsurancePlan::class);
            $baseValueMethod = $this->getProtectedMethod($insurancePlanReflection, 'baseValue');

            $result = $baseValueMethod->invokeArgs($insurancePlan, []);

            $this->assertEquals($data[1], $result);
        }
    }

    public function test_instantiate_rules()
    {
        $rules = [
            [StubRiskRule::class, 'add', 1],
            [StubRiskRule::class, 'add', 1],
            [StubRiskRule::class, 'add', 1]
        ];

        $ui = $this->createMock(UserInformation::class);

        $insurancePlan = new StubInsurancePlan($ui);
        $reflection = $this->getReflection(StubInsurancePlan::class);
        $this->setProtectedPropertyValue($reflection, $insurancePlan, 'rules', $rules);

        $instantiateRulesMethod = $this->getProtectedMethod($reflection, 'instantiateRules');
        $riskRuleInstances = $instantiateRulesMethod->invokeArgs($insurancePlan, []);

        $this->assertNotEmpty($riskRuleInstances);

        foreach ($riskRuleInstances as $instance) {
            $this->assertInstanceOf(RiskRuleHandler::class, $instance);
        }
    }

    public function test_build_chain()
    {
        $riskRule1 = $this->createMock(RiskRuleHandler::class);
        $riskRule2 = $this->createMock(RiskRuleHandler::class);

        $ruleObjects = [$riskRule1, $riskRule2];

        $ui = $this->createMock(UserInformation::class);
        $insurancePlan = new StubInsurancePlan($ui);
        $reflection = $this->getReflection(StubInsurancePlan::class);
        $instantiateRulesMethod = $this->getProtectedMethod($reflection, 'buildChain');
        $chain = $instantiateRulesMethod->invokeArgs($insurancePlan, [$ruleObjects]);

        $this->assertSame($riskRule1, $chain);
    }
}
