<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Exceptions\IneligibleInsurancePlanException;
use App\Exceptions\RiskRuleException;
use App\Models\UserInformation;
use App\Processors\RiskRules\AbstractRiskRuleHandler;
use TestCase;

class StubRiskRuleHandler extends AbstractRiskRuleHandler
{
    public function __construct(UserInformation $ui, Operation $operation, int $value)
    {
        parent::__construct($ui, $operation, $value);
    }

    public function validate(): bool
    {
        return false;
    }
}

class AbstractRiskRuleHandlerTest extends TestCase
{
    protected $reflectionClass;

    public function test_set_next()
    {
        $ui = $this->createMock(UserInformation::class);
        $operation = $this->createMock(Operation::class);
        $value = 2;
        $riskHandler = new StubRiskRuleHandler($ui, $operation, $value);

        $response = $riskHandler->setNext($riskHandler);
        $this->assertEquals($riskHandler, $response);

        $nextHandler = $this->getProtectedPropertyValue($riskHandler, 'nextHandler');
        $this->assertEquals($riskHandler, $nextHandler);
    }

    public function test_add_to_accumulator()
    {
        $ui = $this->createMock(UserInformation::class);
        $operation = $this->createMock(Operation::class);
        $value = 2;

        $riskHandler = new StubRiskRuleHandler($ui, $operation, $value);

        $accumulator = 5;

        $this->assertEquals($accumulator + $value, $riskHandler->addToAccumulator($accumulator));
    }

    public function test_subtract_from_accumulator()
    {
        $ui = $this->createMock(UserInformation::class);
        $operation = $this->createMock(Operation::class);
        $value = 2;

        $riskHandler = new StubRiskRuleHandler($ui, $operation, $value);

        $accumulator = 5;

        $this->assertEquals($accumulator - $value, $riskHandler->subtractFromAccumulator($accumulator));
    }

    public function test_execute_operation_calls_add_to_accumulator()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'operation', Operation::ADD());

        $riskHandler->expects($this->once())->method('addToAccumulator');

        $executeOperation = $this->getProtectedMethod($reflectionClass, 'executeOperation');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_execute_operation_calls_subtract_from_accumulator()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'operation', Operation::SUBTRACT());

        $riskHandler->expects($this->once())->method('subtractFromAccumulator');

        $executeOperation = $this->getProtectedMethod($reflectionClass, 'executeOperation');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_execute_operation_calls_deny()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'operation', Operation::DENY());

        $riskHandler->expects($this->once())->method('deny');

        $executeOperation = $this->getProtectedMethod($reflectionClass, 'executeOperation');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_execute_operation_throws_an_exception_when_operation_is_unknown()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);
        $operation = $this->createMock(Operation::class);

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'operation', $operation);

        $this->expectException(RiskRuleException::class);
        $this->expectExceptionMessage('Operation not found.');

        $executeOperation = $this->getProtectedMethod($reflectionClass, 'executeOperation');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_deny_throws_an_ineligible_insurance_plan_exception()
    {
        $this->expectException(IneligibleInsurancePlanException::class);

        $ui = $this->createMock(UserInformation::class);
        $operation = $this->createMock(Operation::class);
        $value = rand(1, 10);

        $riskHandler = new StubRiskRuleHandler($ui, $operation, $value);

        $riskHandler->deny();
    }

    public function test_handle_calls_validate()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $riskHandler->method('validate')->willReturn(false);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $riskHandler->expects($this->once())->method('validate');

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'nextHandler', null);
        $executeOperation = $this->getProtectedMethod($reflectionClass, 'handle');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_handle_calls_execute_operation()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $riskHandler->method('validate')->willReturn(true);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $riskHandler->expects($this->once())->method('executeOperation');

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'nextHandler', null);
        $executeOperation = $this->getProtectedMethod($reflectionClass, 'handle');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_handle_calls_next_handler()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $riskHandler->method('validate')->willReturn(false);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $riskHandler->expects($this->once())->method('handle');

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'nextHandler', $riskHandler);
        $executeOperation = $this->getProtectedMethod($reflectionClass, 'handle');
        $executeOperation->invokeArgs($riskHandler, [2]);
    }

    public function test_handle_returns_the_accumulator_when_there_is_no_next_handler()
    {
        $riskHandler = $this->createMock(StubRiskRuleHandler::class);
        $riskHandler->method('validate')->willReturn(false);
        $reflectionClass = $this->getReflection(StubRiskRuleHandler::class);

        $this->setProtectedPropertyValue($reflectionClass, $riskHandler, 'nextHandler', null);
        $executeOperation = $this->getProtectedMethod($reflectionClass, 'handle');

        $expected = 2;
        $result = $executeOperation->invokeArgs($riskHandler, [$expected]);

        $this->assertEquals($expected, $result);
    }
}
