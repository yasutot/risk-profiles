<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\HasDependents;
use TestCase;

class HasDependentsTest extends TestCase
{
    protected $userInformation;
    protected $operation;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
    }

    /**
     * @testWith
     *      [0, false]
     *      [1, true]
     *      [2, true]
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getDependents')->will($this->returnValue($input));

        $riskRuleHandler = new HasDependents($this->userInformation, $this->operation);

        $this->assertEquals($expected, $riskRuleHandler->validate());
    }
}