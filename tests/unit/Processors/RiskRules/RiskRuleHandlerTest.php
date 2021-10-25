<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\RiskRuleHandler;
use PHPUnit\Framework\MockObject\MockObject;
use TestCase;

class RiskRuleHandlerTest extends TestCase
{
    protected MockObject $operation;
    protected MockObject $riskHandler;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);

        $this->riskHandler = $this->getMockForAbstractClass(
            RiskRuleHandler::class, [$this->userInformation, $this->operation]
        );
    }

    public function testSetNext()
    {
        $response = $this->riskHandler->setNext($this->riskHandler);

        $this->assertEquals($this->riskHandler, $response);
    }

    public function testHandle()
    {
        $expectedValue = rand(1, 5);
        
        $this->operation->method('execute')->will($this->returnValue($expectedValue));
        $this->riskHandler->method('validate')->will($this->returnValue(true));

        $this->assertEquals($expectedValue, $this->riskHandler->handle());
    }

}
