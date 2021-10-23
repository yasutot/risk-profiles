<?php

namespace Tests\Unit\Models;

use App\Enums\InsurancePlanValue;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Models\InsurancePlan;
use App\Models\UserInformation;
use App\Processors\RiskRules\RiskRuleHandler;
use TestCase;

class InsurancePlanTest extends TestCase
{
    protected $insurance;
    protected $riskRuleHandlerMock;

    public function setUp(): void
    {
        $this->riskRuleHandlerMock = $this->createMock(RiskRuleHandler::class);

        $userInformation = $this->createMock(UserInformation::class);

        $this->insurance = $this->getMockForAbstractClass(InsurancePlan::class, [$userInformation]);
        $this->insurance->method('riskRuleHandlerChain')->will($this->returnValue($this->riskRuleHandlerMock));
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

        $this->assertEquals(InsurancePlanValue::INELIGIBLE(), $this->insurance->evaluate());
    }
}
