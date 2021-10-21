<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\AbstractRiskRuleHandler;
use PHPUnit\Framework\MockObject\MockObject;
use TestCase;

class StubRiskRuleHandler extends AbstractRiskRuleHandler
{
    public function __construct(UserInformation $ui, Operation $operation, int $value)
    {
        parent::__construct($ui, $operation, $value);
    }

    public function validate(): bool {
        return true;
    }
}

class AbstractRiskRuleHandlerTest extends TestCase
{
    protected MockObject $userInformation;
    protected MockObject $operation;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
    }

    public function testSetNext()
    {
        $riskHandler = new StubRiskRuleHandler($this->userInformation, $this->operation, 1);

        $response = $riskHandler->setNext($riskHandler);

        $this->assertEquals($riskHandler, $response);
    }

    public function testHandle()
    {
        $expectedValue = rand(1, 5);

        $this->operation->method('execute')->will($this->returnValue($expectedValue));

        $riskHandler = new StubRiskRuleHandler($this->userInformation, $this->operation, 1);

        $this->assertEquals($expectedValue, $riskHandler->handle());
    }

}
