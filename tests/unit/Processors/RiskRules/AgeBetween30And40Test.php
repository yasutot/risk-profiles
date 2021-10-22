<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\AgeBetween30And40;
use TestCase;

class AgeBetween30And40Test extends TestCase
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
     *      [29, false]
     *      [30, true]
     *      [31, true]
     *      [39, true]
     *      [40, true]
     *      [41, false]
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getAge')->will($this->returnValue($input));

        $riskRuleHandler = new AgeBetween30And40($this->userInformation, $this->operation, 1);

        $this->assertEquals($expected, $riskRuleHandler->validate());
    }
}
