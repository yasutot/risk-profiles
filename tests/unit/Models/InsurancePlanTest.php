<?php

namespace Tests\Unit\Models;

use App\Enums\InsurancePlanValue;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Models\InsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;
use ReflectionClass;
use TestCase;

class InsurancePlanTest extends TestCase
{
    protected $insurance;
    protected $riskRuleHandlerMock;

    public function setUp(): void
    {
        $this->insurance = $this->getMockForAbstractClass(InsurancePlan::class, [], 'stubInsurance', false);
        
        $this->riskRuleHandlerMock = $this->createMock(RiskRuleHandler::class);
        $this->setProtectedProperty($this->insurance, 'riskRuleChain', $this->riskRuleHandlerMock);

        $userInformation = $this->createMock(UserInformation::class);
        $userInformation->method('getRiskQuestions')->will($this->returnValue([0,0,0]));
        $this->setProtectedProperty($this->insurance, 'userInformation', $userInformation);
    }

    /**
     * @dataProvider validateDataProvider
     */
    public function testValidate($input, $expected)
    {
        $this->riskRuleHandlerMock->method('handle')->will($this->returnValue($input));

        $this->assertEquals($expected, $this->insurance->evaluate());
    }

    public function validateDataProvider()
    {
        return [
            [-1, InsurancePlanValue::ECONOMIC()],
            [0, InsurancePlanValue::ECONOMIC()],
            [1, InsurancePlanValue::REGULAR()],
            [2, InsurancePlanValue::REGULAR()],
            [3, InsurancePlanValue::RESPONSIBLE()],
        ];
    }

    public function testValidateReturnsIneligible()
    {
        $this->riskRuleHandlerMock
            ->method('handle')
            ->will($this->throwException(new IneligibleInsurancePlanException()));

            $eval = $this->insurance->evaluate();
        $this->assertEquals(InsurancePlanValue::INELIGIBLE(), $this->insurance->evaluate());
    }

    private function setProtectedProperty($obj, $property, $value)
    {
        $reflection = new ReflectionClass($obj);
        $riskRuleChain = $reflection->getProperty($property);
        $riskRuleChain->setAccessible(true);
        $riskRuleChain->setValue($obj, $value);
        $riskRuleChain->setAccessible(false);
    }
}
