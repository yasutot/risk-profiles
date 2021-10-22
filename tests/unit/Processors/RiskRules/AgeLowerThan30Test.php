<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\AgeLowerThan30;
use TestCase;

class AgeLowerThan30Test extends TestCase
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
     *      [29, true]
     *      [30, false]
     *      [31, false]
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getAge')->will($this->returnValue($input));

        $riskRuleHandler = new AgeLowerThan30($this->userInformation, $this->operation, rand(1,2));

        $this->assertEquals($expected, $riskRuleHandler->validate());
    }
}