<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\MaritalStatus;
use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\IsMarried;
use TestCase;

class IsMarriedTest extends TestCase
{
    protected $userInformation;
    protected $operation;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
    }

    /**
     * @dataProvider dataset
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getMaritalStatus')->will($this->returnValue($input));

        $riskRuleHandler = new IsMarried($this->userInformation, $this->operation, rand(1,2));

        $this->assertEquals($expected, $riskRuleHandler->validate());
    }

    public function dataSet()
    {
        return [
            [MaritalStatus::MARRIED(), true],
            [MaritalStatus::SINGLE(), false]
        ];
    }
}